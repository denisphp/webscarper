<?php

namespace api\modules\v1\controllers\article;

use api\components\BaseApiAction;
use api\models\Article;
use mobidev\swagger\components\api\DataValidationHttpException;

/**
 * Class ViewAction
 *
 * @package api\modules\v1\controllers\article
 */
class ViewAction extends BaseApiAction
{
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'integer']
        ];
    }

    public function run($id)
    {
        $model = Article::find()
            ->where(['article.status' => Article::STATUS_ACTIVE])
            ->andWhere(['article.id' => $id])
            ->joinWith([
               'articleContent ac' => function ($query) {
                   $query->orderBy('ac.id DESC');
                }
            ])
            ->one();
        /**@var $model Article*/
        if ($model) {
            $content = $model->articleContent[0];
            $article = [
                'id' => $model->id,
                'title' => $model->title,
                'url' => $model->url,
                'flow' => $model->flow,
                'current_version' => $content->version,
                'current_html' => $content->html,
            ];

            return ['article' => $article];
        }

        return new DataValidationHttpException('Article not found.');
    }

    public function description()
    {
        return '
        GET Parameters:
            "id" integer (required)
        ';
    }
}
