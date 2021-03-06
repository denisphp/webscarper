<?php

namespace api\modules\v1\controllers\article;

use api\components\BaseApiAction;
use api\models\Article;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class ChangedListAction
 *
 * @package api\modules\v1\controllers\article
 */
class ChangedListAction extends BaseApiAction
{
    const DEFAULT_PAGE_SIZE = 12;
    const DEFAULT_PAGE = 0;

    public function rules()
    {
        return [
            [['page', 'limit'], 'integer'],
            ['limit', 'default', 'value' => self::DEFAULT_PAGE_SIZE],
            ['page', 'default', 'value' => self::DEFAULT_PAGE],
        ];
    }

    public function run()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getQuery(),
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC
                ]
            ],
            'pagination' => [
                'page' => $this->model->page,
                'pageSize' => $this->model->limit,
            ],
        ]);

        $articles = [];
        foreach ($dataProvider->getModels() as $model) {
            /**@var $model Article */
            $content = $model->articleContent[0];
            $articles[] = ArrayHelper::merge($model->toArray(), [
                'current_version' => $content->version
            ]);
        }

        return [
            'page' => $dataProvider->getPagination()->getPage(),
            'limit' => $dataProvider->getPagination()->getLimit(),
            'total_count' => $dataProvider->getTotalCount(),
            'count' => $dataProvider->getCount(),
            'articles' => $articles
        ];
    }

    protected function getQuery()
    {
        $query = Article::find()
            ->where(['status' => Article::STATUS_ACTIVE])
            ->andWhere(['is_changed' => true])
            ->joinWith([
                'articleContent ac' => function ($query) {
                    $query->orderBy('ac.id DESC');
                }
            ]);

        return $query;
    }

    public function description()
    {
        return '
        GET Parameters:
            "page"        integer (default 0) (optional)
            "limit"       integer (default 12) (optional)
        ';
    }
}
