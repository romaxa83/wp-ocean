<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'timeZone' => 'Europe/Kiev',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queue'
    ],
    'components' => [
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@console/runtime/queue',
            'as log' => \yii\queue\LogBehavior::class,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'UTC',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'forceCopy' => true
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
//            'cache' => 'cache' //Включаем кеширование
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            //'botToken' => '633288703:AAFxEeNzgz3eV3u01F3isikEILCQCJDRnqk', // test
            'botToken' => '735997657:AAHdIniBxgQFKVGEl-8vF1qf_4uULcHmrGo', // prod
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.5okean.com',
                'username' => 'noreply@5okean.com',
                'password' => 'cXvtZ58n',
                'port' => '587',
                'encryption' => 'tls'
            ],
        ],
    ],
];
