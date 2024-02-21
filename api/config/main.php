<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'api-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null, // disable login page
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'user',
                        'attendance',
                        'cleanitem',
                        'company',
                        'customer',
                        'order',
                        'orderitem',
                        'typeemployer',
                        'main',
                    ],
                ],
                'POST auth/login' => 'auth/login',
                'GET attendance/findbyuserid' => 'attendance/findbyuserid',
                'GET attendance/find' => 'attendance/find',
                'GET attendance/date' => 'attendance/date',
                'GET customer/searchbyphone' => 'customer/searchbyphone',
                'GET order/search' => 'order/search',
                'GET customer/searchbyname' => 'customer/searchbyname',
                'GET order/bringing' => 'order/bringing',
                'GET order/cleaning' => 'order/cleaning',
                'GET order/drying' => 'order/drying',
                'GET order/packaging' => 'order/packaging',
                'GET order/delivering' => 'order/delivering',
                'GET order/complete' => 'order/complete',
            ],
        ]
    ],
    'params' => $params,
];