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

        $page = \Yii::$app->params['habra.flow.url'] . '/' . $flow . '/page1';
        $dom = \Yii::$app->scarper->load($page);
        if ($dom) {
            $nodes = \Yii::$app->scarper->getNodes($dom, \Yii::$app->params['habra.postLink.xpath']);
            foreach ($nodes as $node) {
                /**@var $node \DOMElement */
                $articleUrl = $node->getAttribute('href');
                $exists = \Yii::$app->article->exists($articleUrl);
                if (!$exists) {
                    $articleDom = \Yii::$app->scarper->load($articleUrl);
                    \Yii::$app->article->createNewRecord($articleUrl, $articleDom, $flowId);
                }
            }
        }

        return 0;
    }
}