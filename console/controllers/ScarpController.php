<?php

namespace console\controllers;

use common\helpers\Flow;
use common\models\Article;
use common\models\ArticleContent;
use yii\base\Exception;
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
            $nodes = \Yii::$app->scarper->getNodes($dom, '//*[@class="post__title_link"]');
            foreach ($nodes as $node) {
                /**@var $node \DOMElement */

                $href = $node->getAttribute('href');
                $articleDom = $this->loadPage($href);
                $exists = Article::find()->where(['url' => $href])->exists();

                if (!$exists && $articleDom) {
                    try {
                        $articleBody = \Yii::$app->scarper->getNode($articleDom, '//*[@class="post post_full"]');
                        $title = \Yii::$app->scarper->getNode($articleDom, '//*[@class="post__title-text"]');

                        $transaction = \Yii::$app->db->beginTransaction();

                        $article = new Article();
                        $article->flow = $flowId;
                        $article->title = $title->nodeValue;
                        $article->url = $href;
                        if ($article->save()) {
                            $articleContent = new ArticleContent();
                            $articleContent->article_id = $article->id;
                            $articleContent->html = $articleBody->nodeValue;
                            $articleContent->save();
                        }

                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }
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