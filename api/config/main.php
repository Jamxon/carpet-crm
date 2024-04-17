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
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Api',
        ],
    ],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            // ...
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
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
                        'salary',
                        'kpi',
                        'chiqim',
                        'chiqimtype',
                        'v1/auth',
                        'v1/main',
                    ],
                ],
                'POST v1/auth/login' => 'v1/auth/login',
                'POST v1/auth/register' => 'v1/auth/register',
                'POST auth/login' => 'auth/login',
                'GET user/getdriver' => 'user/getdriver',
                'GET user/options' => 'user/options',
                'GET user/index' => 'user/index',
                'POST user/create' => 'user/create',
                'GET user/getblockedusers' => 'user/getblockedusers',
                'PATCH user/blockuser/{id}' => 'user/blockuser',
                'GET attendance/options' => 'attendance/options',
                'GET attendance/index' => 'attendance/index',
                'POST attendance/date' => 'attendance/date',
                'POST attendance/create' => 'attendance/create',
                'GET attendance/go' => 'attendance/go',
                'GET customer/search' => 'customer/search',
                'GET customer/options' => 'customer/options',
                'GET customer/index' => 'customer/index',
                'POST customer/create' => 'customer/create',
                'PATCH customer/update' => 'customer/update',
                'DELETE customer/delete' => 'customer/delete',
                'GET order/search' => 'order/search',
                'GET order/bringing' => 'order/bringing',
                'GET order/cleaning' => 'order/cleaning',
                'GET order/drying' => 'order/drying',
                'GET order/packaging' => 'order/packaging',
                'GET order/delivering' => 'order/delivering',
                'GET order/complete' => 'order/complete',
                'GET order/cancelled' => 'order/cancelled',
                'GET main/options' => 'main/options',
                'GET main/index' => 'main/index',
                'GET main/registered_customer' => 'main/registered_customer',
                'GET main/registered_order' => 'main/registered_order',
                'GET main/receive_order' => 'main/receive_order',
                'GET main/bringing' => 'main/bringing',
                'GET main/cancelled' => 'main/cancelled',
                'GET main/cleaned' => 'main/cleaned',
                'GET main/registered_order_item' => 'main/registered_order_item',
                'GET main/packaged' => 'main/packaged',
                'GET main/completed' => 'main/completed',
            ],
        ]
    ],
    'params' => $params,
];