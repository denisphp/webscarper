<?php

namespace common\components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
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

    public function init()
    {
        $this->webClient = new Client();
    }

    /**
     * @param $page
     * @return mixed
     */
    public function load($page)
    {
        try {
            $response = $this->webClient->get($page, ['exceptions' => false]);

            $data['code'] = $response->getStatusCode();
            $data['message'] = $response->getReasonPhrase();

            if ($data['code'] === 200) {
                $html = $response->getBody();
                $dom = new DOMDocument();

                libxml_use_internal_errors(true);
                $dom->loadHTML($html);
                libxml_clear_errors();
                $data['dom'] = $dom;
            }
        } catch (ConnectException $e) {
            $data['code'] = $e->getCode();
            $data['message'] = $e->getMessage();
        }

        return $data;
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
