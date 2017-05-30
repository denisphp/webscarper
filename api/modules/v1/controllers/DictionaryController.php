<?php

namespace api\modules\v1\controllers;

use api\components\BaseApiController;

/**
 * Class DictionaryController
 *
 * @package api\modules\v1\controllers
 */
class DictionaryController extends BaseApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view'];
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'view' => ['get'],
        ];
    }

    public function actions()
    {
        return [
            'view' => 'api\modules\v1\controllers\dictionary\ViewAction'
        ];
    }
}
