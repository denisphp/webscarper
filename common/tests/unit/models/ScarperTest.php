<?php

namespace common\tests\unit\models;

use common\helpers\Flow;
use Yii;


/**
 * ScarperTest form test
 */
class ScarperTest extends \Codeception\Test\Unit
{
    public function testLoadPage()
    {
        foreach (Flow::getList() as $flow) {
            $page = Yii::$app->params['flow.url'] . '/' . $flow['name'];
            $response = Yii::$app->scarper->load($page);

            expect('status code equal 200', $response['code'])->equals(200);
            expect('dom instance of DOMDocument', get_class($response['dom']))->equals(\DOMDocument::class);
        }
    }

    public function testGetNodes()
    {
        $nodes = $this->getNodesByFlow(Flow::getIdByName(Flow::ADMIN));
        foreach ($nodes as $node) {
            $href = $node->getAttribute('href');
            expect('node href attribute', $href)->notEmpty();
        }
    }

    public function testGetNode()
    {
        $nodes = $this->getNodesByFlow(Flow::getIdByName(Flow::DEVELOP));
        foreach ($nodes as $node) {
            $page = $node->getAttribute('href');
            $response = Yii::$app->scarper->load($page);
            $bodyNode = \Yii::$app->scarper->getNode($response['dom'], \Yii::$app->params['postBody.xpath']);
            $titleNode = \Yii::$app->scarper->getNode($response['dom'], \Yii::$app->params['postTitle.xpath']);
            expect('node href attribute', $bodyNode)->notEmpty();
            expect('node href attribute', $titleNode)->notEmpty();
        }
    }

    private function getNodesByFlow($flow)
    {
        $page = Yii::$app->params['flow.url'] . '/' . $flow;
        $response = Yii::$app->scarper->load($page);
        return \Yii::$app->scarper->getNodes($response['dom'], \Yii::$app->params['postLink.xpath']);
    }
}
