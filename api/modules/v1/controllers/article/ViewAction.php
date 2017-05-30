<?php

namespace api\modules\v1\controllers\article;

use api\components\BaseApiAction;
use api\models\Article;
use mobidev\swagger\components\api\DataValidationHttpException;
use yii\helpers\ArrayHelper;

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
            ['id', 'integer'],
            ['version', 'integer']
        ];
    }

    public function run()
    {
        $query = $this->getQuery();
        $model = $query->one();
        if ($model) {
            /**@var $model Article */
            $content = $model->articleContent[0];
            $article = ArrayHelper::merge($model->toArray(), [
                'html' => $content->html,
            ]);

            return ['article' => $article];
        }

        return new DataValidationHttpException('Article not found.');
    }

    protected function getQuery()
    {
        $query = Article::find()
            ->where(['article.status' => Article::STATUS_ACTIVE])
            ->andWhere(['article.id' => $this->model->id])
            ->joinWith([
                'articleContent ac' => function ($query) {
                    if ($this->model->version) {
                        $query->andWhere(['ac.version' => $this->model->version]);
                    }
                    $query->orderBy('ac.id DESC');
                }
            ]);

        return $query;
    }

    public function description()
    {
        return '
        GET Parameters:
            "id" integer (required),
            "version" integer (optional)
        ';
    }
}
