<?php

namespace common\components;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use yii\base\Exception;

class Scarper
{
    private $webClient;

    private $dom;


    public function __construct($baseUrl, $timeout = 2)
    {
        $this->webClient = new Client([
            'base_url' => $baseUrl,
            'defaults' => [
                'timeout' => $timeout,
            ]
        ]);
    }

    public function load($page)
    {
        try {
            $response = $this->webClient->get($page);
        } catch (ConnectException $e) {
            throw new Exception($e->getMessage());
        }

        $html = $response->getBody();
        $this->dom = new \DOMComment();

        // Ignore errors caused by unsupported HTML5 tags
        libxml_use_internal_errors(true);
        $this->dom->loadHTML($html);
        libxml_clear_errors();

        return $this;
    }

    /**
     * Get first nodes matching xpath query
     * below parent node in DOM tree
     *
     * @param $xpath string selector to query the DOM
     * @param $parent \DOMNode to use as query root node
     * @return mixed
     * @throws Exception
     */
    public function getNode($xpath, $parent = null)
    {
        $nodes = $this->getNodes($xpath, $parent);

        if ($nodes->length === 0) {
            throw new Exception("No matching node found");
        }

        return $nodes[0];
    }

    /**
     * Get all nodes matching xpath query
     * below parent node in DOM tree
     *
     * @param $xpath string selector to query the DOM
     * @param $parent \DOMNode to use as query root node
     * @return \DOMNodeList
     */
    public function getNodes($xpath, $parent = null)
    {
        $DomXpath = new \DOMXPath($this->dom);
        $nodes = $DomXpath->query($xpath, $parent);
        return $nodes;
    }
}
