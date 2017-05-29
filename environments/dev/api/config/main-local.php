<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'ahX8poodoxai1uothiePh5ieNgaima',
        ],
        'session' => [
            'class' => 'api\components\ApiSession',
            'useCookies' => false, //set php.ini to session.use_cookies = 0, session.use_only_cookies = 0
            'useTransparentSessionID' => true, //set php.ini to session.use_trans_sid = 1
            'name' => 'api_key',
            'timeout' => 86400 * 365, //24h * 365 days
            'keyPrefix' => \common\models\User::REDIS_API_SESSION_KEY_PREFIX,
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => \common\models\User::REDIS_API_SESSION_DATABASE,
            ]
        ],
    ],
];