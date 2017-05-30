<?php

namespace api\modules\v1\controllers;

use api\components\BaseApiController;

class ArticleController extends BaseApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['list', 'view', 'diff', 'changed-list'];

        return $behaviors;
    }

    public function verbs()
    {
        return [
            'list' => ['get'],
            'view' => ['get'],
            'diff' => ['get'],
            'changed-list' => ['get'],
        ];
    }

    public function actions()
    {
        return [
            'list' => 'api\modules\v1\controllers\article\ListAction',
            'view' => 'api\modules\v1\controllers\article\ViewAction',
            'diff' => 'api\modules\v1\controllers\article\VersionsDiffAction',
            'changed-list' => 'api\modules\v1\controllers\article\ChangedListAction'
        ];
    }
}
