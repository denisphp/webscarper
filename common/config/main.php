<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'scarper' => 'common\components\Scarper',
        'article' => 'common\components\Article',
        'text' => 'common\components\Text'
    ],
];
