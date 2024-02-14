<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
//        'on beforeSend' => function ($event) {
//            $response = $event->sender;
//            $response->headers->add('Access-Control-Allow-Origin', 'http://127.0.0.1:5500');
//            $response->headers->add('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
//            $response->headers->add('Access-Control-Allow-Headers', 'Authorization, Content-Type');
//            $response->headers->add('Access-Control-Allow-Credentials', 'true');
//            $response->headers->add('Access-Control-Max-Age', '3600');
//        },

    ],
];
