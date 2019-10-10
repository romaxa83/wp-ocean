<?php

$frontend = require(__DIR__ . '/../../frontend/config/main.php');

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'backend\modules\content\migrations',
                'backend\modules\content\migrations\projectMigrations',
                'backend\modules\menuBuilder\migrations',
                'backend\modules\menuBuilder\migrations\projectMigrations',
            ],
        ],
        'sitemap' => [
            'class' => 'demi\sitemap\SitemapController',
            'modelsPath' => '@console/models/sitemap', // Sitemap-data models directory
            'modelsNamespace' => 'console\models\sitemap', // Namespace in [[modelsPath]] files
            'savePathAlias' => '@frontend/web', // Where would be placed the generated sitemap-files
            'sitemapFileName' => 'sitemap.xml', // Name of main sitemap-file in [[savePathAlias]] directory
        ],
    ],
    'components' => [
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '633288703:AAFxEeNzgz3eV3u01F3isikEILCQCJDRnqk',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@console/runtime/cache'
        ],
        'urlManager' => $frontend['components']['frontendUrlManager'],
    ],
    'params' => $params,
];
