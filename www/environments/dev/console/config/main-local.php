<?php
return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        // fix console create url
        'urlManager' => [
            'baseUrl' => 'https://5okean.com',
        ],
    ],
];
