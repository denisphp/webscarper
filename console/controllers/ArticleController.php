<?php

namespace console\controllers;

use common\helpers\Flow;
use common\models\Article;
use yii\console\Controller;

class ArticleController extends Controller
{
    public function actionCreate($flow = 'develop')
    {
        $response = \Yii::$app->scarper->load(\Yii::$app->params['flow.url'] . '/' . $flow);
        if ($response['code'] === 200) {
            $nodes = \Yii::$app->scarper->getNodes($response['dom'], \Yii::$app->params['postLink.xpath']);
            foreach ($nodes as $node) {
                \Yii::$app->article->create($node->getAttribute('href'), Flow::getIdByName($flow));
            }
        }
    }

    public function actionUpdate()
    {
        $query = Article::find()->live();

        foreach ($query->each() as $article) {
            \Yii::$app->article->update($article);
        }
    }
}
