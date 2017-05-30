<?php

namespace console\controllers;

use common\helpers\Flow;
use common\models\Article;
use common\models\ArticleContent;
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

    /**
     * Scarp specific article from detect if it has changed
     *
     *
     * @return int the status of the action execution. 0 means normal, other values mean abnormal.
     */
    public function actionArticleVersion()
    {
        $query = Article::find()
            ->live()
            ->joinWith([
                'articleContent ac' => function ($query) {
                    $query->orderBy('ac.id DESC');
                }
            ]);
        foreach ($query->each() as $article) {
            /**@var ArticleContent $articleContent */
            $articleContent = $article->articleContent[0];
            $articleDom = \Yii::$app->scarper->load($article->url);
            if ($articleDom) {
                $articleBody = \Yii::$app->scarper->getNode($articleDom, \Yii::$app->params['habra.postBody.xpath']);
                if (\Yii::$app->text->diff($articleContent->html, $articleBody->nodeValue)) {
                    $content = new ArticleContent();
                    $content->article_id = $article->id;
                    $content->html = $articleBody->nodeValue;
                    $content->version = $articleContent->version + 1;
                    $content->save();
                }
            } else {
                $article->status = Article::STATUS_DELETED;
                $article->save();
            }
        }

        return 0;
    }
}