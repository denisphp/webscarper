<?php
return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'swagger' => [
            'class' => 'mobidev\swagger\Module',
            'jsonPath' => '@api/web/swagger.json',
            'host' => 'api.webscarper.local',
            'basePath' => '/v1',
            'description' => 'Web Scarper API documentation',
            'defaultInput' => 'body',
            'additionalFields' => []
        ],
    ],
];
