<?php

namespace api\components;

use mobidev\swagger\components\api\Controller;

class BaseApiController extends Controller
{
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        return $result;
    }
}
