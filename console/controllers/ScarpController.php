<?php

namespace console\controllers;

use common\helpers\Flow;
use yii\console\Controller;
use yii\helpers\Console;

class ScarpController extends Controller
{

    /**
     * Scarp all articles from  https://habrahabr.ru/
     * For example,
     *
     * ```
     * yii scarp/flow development     # scarp all articles for development flow
     * ```
     *
     * @param string $flow the flow name to be applied. If 0, it means
     * applying scarper for development articles.
     *
     * @return int the status of the action execution. 0 means normal, other values mean abnormal.
     */
    public function actionFlow($flow = 'develop')
    {
        $flowId = Flow::getIdByName($flow);
        if (!$flowId) {
            $this->stdout("Flow is not exist", Console::BG_RED);
            return 1;
        }

        $flowUrl = $this->getFlowUrl($flow);
        $dom = $this->loadPage($flowUrl);

        if ($dom) {
            $nodes = \Yii::$app->scarper->getNodes($dom, \Yii::$app->params['habra.postLink.xpath']);
            foreach ($nodes as $node) {
                /**@var $node \DOMElement */
                $href = $node->getAttribute('href');
                $articleDom = $this->loadPage($href);
                $exists = \Yii::$app->article->exists($href);
                if ($articleDom && !$exists) {
                    \Yii::$app->article->createNewRecord($href, $articleDom, $flowId);
                }
            }
        }

        return 0;
    }

    protected function getFlowUrl($flow, $page = 1)
    {
        return \Yii::$app->params['habra.flow.url'] . '/' . $flow . '/page' . $page;
    }

    /**
     * @param $url
     * @return \DOMDocument|null
     */
    protected function loadPage($url)
    {
        return \Yii::$app->scarper->load($url);
    }
}