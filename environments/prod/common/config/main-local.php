<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=142.132.192.157;dbname=x_u_12889_carpet-crm',
            'username' => 'x_u_12889_jamkhan',
            'password' => '09022005Jam',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
];
