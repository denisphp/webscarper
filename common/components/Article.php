<?php

namespace common\components;

use yii\base\Component;
use common\models\Article as Post;
use common\models\ArticleContent as Content;
use yii\db\Exception;
use api\models\ArticleContent;

class Article extends Component
{
    public function create($url, $flow = null)
    {
        $response = \Yii::$app->scarper->load($url);
        if ($response['code'] === 200) {
            $bodyNode = \Yii::$app->scarper->getNode($response['dom'], \Yii::$app->params['postBody.xpath']);
            $titleNode = \Yii::$app->scarper->getNode($response['dom'], \Yii::$app->params['postTitle.xpath']);

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $article = new Post();
                $article->flow = $flow;
                $article->title = $titleNode->nodeValue;
                $article->url = $url;

                if ($article->save()) {
                    $content = new Content();
                    $content->article_id = $article->id;
                    $content->html = $bodyNode->nodeValue;
                    $content->save();
                }

                $transaction->commit();
                return $article;
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return null;
    }

    public function update(Post $article)
    {
        $content = ArticleContent::find()->where(['article_id' => $article->id])->orderBy("version DESC")->one();
        /**@var $content ArticleContent*/
        $response = \Yii::$app->scarper->load($article->url);
        if ($response['code'] === 200) {
            $bodyNode = \Yii::$app->scarper->getNode($response['dom'], \Yii::$app->params['postBody.xpath']);
            $diff = \Yii::$app->text->diff($content->html, $bodyNode->nodeValue);
            if ($diff) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $articleContent = new ArticleContent();
                    $articleContent->article_id = $article->id;
                    $articleContent->html = $bodyNode->nodeValue;
                    $articleContent->version = $content->version + 1;
                    if ($articleContent->save()) {
                        $article->is_changed = true;
                        $article->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        if ($response['code'] === 404) {
            $article->status = Post::STATUS_DELETED;
            $article->save();
        }

        return $article;
    }
}
