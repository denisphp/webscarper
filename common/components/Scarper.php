<?php

namespace common\components;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use yii\base\Component;
use yii\base\Exception;
use DOMDocument;
use DOMXPath;

class Scarper extends Component
{
    /**
     * @var Client
     */
    private $webClient;

    protected $_errors = [];

    public function init()
    {
        $this->webClient = new Client();
    }

    /**
     * @param $page
     * @return DOMDocument|null
     */
    public function load($page)
    {
        try {
            $response = $this->webClient->get($page);
            $html = $response->getBody();
            $dom = new DOMDocument();

            libxml_use_internal_errors(true);
            $dom->loadHTML($html);
            libxml_clear_errors();
        } catch (ClientException $e) {
            $this->_errors[] = $e->getMessage();
            return null;
        }

        return $dom;
    }

    /**
     * Get first nodes matching xpath query
     * below parent node in DOM tree
     *
     * @param $dom DOMDocument
     * @param $xpath string selector to query the DOM
     * @param $parent \DOMNode to use as query root node
     * @return mixed
     * @throws Exception
     */
    public function getNode($dom, $xpath, $parent = null)
    {
        $nodes = $this->getNodes($dom, $xpath, $parent);

        if ($nodes->length === 0) {
            throw new Exception("No matching node found");
        }

        return $nodes[0];
    }

    /**
     * Get all nodes matching xpath query
     * below parent node in DOM tree
     *
     * @param $dom DOMDocument
     * @param $xpath string selector to query the DOM
     * @param $parent \DOMNode to use as query root node
     * @return \DOMNodeList
     */
    public function getNodes($dom, $xpath, $parent = null)
    {
        $DomXpath = new DOMXPath($dom);
        $nodes = $DomXpath->query($xpath, $parent);
        return $nodes;
    }
}
