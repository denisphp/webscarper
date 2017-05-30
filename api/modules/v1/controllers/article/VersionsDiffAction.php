<?php

namespace api\modules\v1\controllers\article;

use api\components\BaseApiAction;
use api\models\Article;
use mobidev\swagger\components\api\DataValidationHttpException;
use yii\helpers\ArrayHelper;


/**
 * Class VersionsDiffAction
 *
 * @package api\modules\v1\controllers\article
 */
class VersionsDiffAction extends BaseApiAction
{
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'integer'],
            ['version_from', 'required'],
            ['version_from', 'integer'],
            ['version_to', 'required'],
            ['version_to', 'integer'],
        ];
    }

    public function run()
    {
        $article = Article::find()
            ->where(['article.id' => $this->model->id])
            ->andWhere(['article.status' => Article::STATUS_ACTIVE])
            ->joinWith([
                'articleContent ac' => function ($query) {
                    $query->where(['ac.version' => [$this->model->version_from, $this->model->version_to]]);
                }
            ])
            ->one();
        /**@var $article Article */
        if ($article && (count($article->articleContent) == 2)) {
            $keyFrom = array_search($this->model->version_from, ArrayHelper::getColumn($article->articleContent, 'version'));
            $keyTo = array_search($this->model->version_to, ArrayHelper::getColumn($article->articleContent, 'version'));

            $from = $article->articleContent[$keyFrom];
            $to = $article->articleContent[$keyTo];

            $article = [
                'id' => $article->id,
                'version_from' => (int)$this->model->version_from,
                'version_to' => (int)$this->model->version_to,
                'diff' => \Yii::$app->text->diff($from->html, $to->html)
            ];

            return ['article' => $article];
        }

        return new DataValidationHttpException('Article with given versions does not exist.');
    }

    public function description()
    {
        return '
        GET Parameters:
            "id" integer (required),
            "version_from" integer (required),
            "version_to" integer (required),
        ';
    }
}
