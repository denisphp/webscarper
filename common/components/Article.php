<?php

namespace common\components;

use yii\base\Component;
use common\models\ArticleContent as Content;
use common\models\Article as Post;
use yii\base\Exception;

class Article extends Component
{
    /**
     * @param $url
     * @param $dom \DOMDocument
     * @param $flowId
     * @return \common\models\Article|null
     */
    public function createNewRecord($url, $dom, $flowId)
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $articleBody = \Yii::$app->scarper->getNode($dom, \Yii::$app->params['habra.postBody.xpath']);
            $title = \Yii::$app->scarper->getNode($dom, \Yii::$app->params['habra.postTitle.xpath']);

            $article = new Post();
            $article->flow = $flowId;
            $article->title = $title->nodeValue;
            $article->url = $url;
            if ($article->save()) {
                $articleContent = new Content();
                $articleContent->article_id = $article->id;
                $articleContent->html = $articleBody->nodeValue;
                $articleContent->save();
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return null;
        }

        return $article;
    }

    public function exists($url)
    {
        return Post::find()
            ->where(['url' => $url])
            ->exists();
    }
}
