<?php

namespace api\components;

use yii\redis\Session as RedisSession;
use common\models\User;

class ApiSession extends RedisSession
{
    public function calculateKey($id)
    {
        return User::calculateRedisApiSessionKey($id);
    }
}
