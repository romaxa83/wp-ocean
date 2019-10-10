<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
//        'debug'
    ],
    'language' => 'ru',
    'modules' => [
//        'debug' => [
//            'class' => 'yii\debug\Module',
//            'allowedIPs' => ['*']
//        ],
        'referenceBooks' => [
            'class' => 'backend\modules\referenceBooks\referenceBooks',
        ],
        'filemanager' => [
            'class' => 'backend\modules\filemanager\FileManager',
//            'thumbs' => [
//                'small' => [
//                    'name' => 'Мелкий',
//                    'size' => [100, 100],
//                ],
//                'medium' => [
//                    'name' => 'Средний',
//                    'size' => [300, 200],
//                ],
//                'large' => [
//                    'name' => 'Большой',
//                    'size' => [500, 400],
//                ],
//            ],
        ],
        'blog' => [
            'class' => 'backend\modules\blog\Blog',
        ],
        'user' => [
            'class' => 'backend\modules\user\User',
        ],
        'faq' => [
            'class' => 'backend\modules\faq\Faq',
        ],
        'dispatch' => [
            'class' => 'backend\modules\dispatch\Dispatch',
        ],
        'seo' => [
            'class' => 'backend\modules\seo\Seo',
        ],
        'seoSearch' => [
            'class' => 'backend\modules\seoSearch\SeoSearch',
        ],
        'staticBlocks' => [
            'class' => 'backend\modules\staticBlocks\StaticBlocks',
        ],
        'order' => [
            'class' => 'backend\modules\order\Order',
        ],
        'request' => [
            'class' => 'backend\modules\request\Request',
        ],
        'content' => [
            'class' => 'backend\modules\content\Page',
        ],
        'settings' => [
            'class' => 'backend\modules\settings\Settings',
        ],
        'filter' => [
            'class' => 'backend\modules\filter\Filter',
        ],
        'vacancyNotification' => [
            'class' => 'backend\modules\vacancyNotification\VacancyNotification',
        ],
        'menuBuilder' => [
            'class' => 'backend\modules\menuBuilder\MenuBuilder',
        ],
        'specials' => [
            'class' => 'backend\modules\specials\Specials'
        ]
    ],
    'components' => [
        'ga' => [
            'class' => 'baibaratsky\yii\google\analytics\MeasurementProtocol',
            'trackingId' => $params['GAtrackingId'], // Put your real tracking ID here
            'useSsl' => true, // If you’d like to use a secure connection to Google servers
            'overrideIp' => false, // By default, IP is overridden by the user’s one, but you can disable this
            'anonymizeIp' => true, // If you want to anonymize the sender’s IP address
            'asyncMode' => true, // Enables the asynchronous mode (see below)
            'autoSetClientId' => true, // Try to set ClientId automatically from the “_ga” cookie (disabled by default)
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '633288703:AAFxEeNzgz3eV3u01F3isikEILCQCJDRnqk',
        ],
        'consoleRunner' => [
            'class' => 'vova07\console\ConsoleRunner',
            'file' => Yii::getAlias('@app') . '/yii' // or an absolute path to console file
        ],
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 0,
            ]
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'datetimeFormat' => 'php:d-m-Y в H:i:s'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            //'showScriptName' => false,
            'rules' => [
                ['class' => 'backend\urls\AdminRule'],
                'api' => 'api/index',
                'api/index/json-schema' => 'api/index/json-schema',
                'api/test' => 'api/index/test',
                'vacancy-notification' => 'vacancyNotification/notification',
//                '/user/<action>' => '/user/user/<action>'
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'backend\modules\content\components\PageRule',
                    'connectionID' => 'db',
                ]
            ]
        ],
    ],
    'params' => $params,
];
