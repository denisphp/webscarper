<?php

namespace api\components;

use mobidev\swagger\components\api\Action;
use yii\web\Response;

class BaseApiAction extends Action
{
    /** @var string */
    public $modelClass = 'yii\base\DynamicModel';

    public function responses()
    {
        return [
            200 => [
                'description' => Response::$httpStatuses[200],
            ],
            401 => [
                'description' => Response::$httpStatuses[401],
            ],
            421 => [
                'description' => 'Location not found',
            ],
            422 => [
                'description' => Response::$httpStatuses[422].'. Validation error',
            ],
            500 => [
                'description' => Response::$httpStatuses[500],
            ]
        ];
    }
}