<?php

/** @var array $params */
return [
    'class' => 'yii\web\UrlManager',
//    'hostInfo' => $params['frontendHostInfo'],
    'baseUrl' => '',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'cache' => false,
    'rules' => [
        'layout/<action:[\w- ]+>' => 'layout/index',
        'search/search-result' => 'search/search-result',
        'search/filter' => 'search/filter',
        'search/show-more' => 'search/show-more',
        'search/set-view' => 'search/set-view',
        'search/<country:[\w- ]+>-<dept_city:[\w_]+>' => 'search/index',
        'search/<country:[\w- ]+>-<dept_city:[\w_]+>/<city:[\w-:]+>' => 'search/index',
        'search/<country:[\w- ]+>' => 'search/index',
        'search/<country:[\w- ]+>/<city:[\w-:]+>' => 'search/index',
        'tour/get-info' => 'tour/get-info',
        'tour/search-offers' => 'tour/search-offers',
        'tour/save-request' => 'tour/save-request',
        'tour/save-order' => 'tour/save-order',
        'tour/get-block-offers' => 'tour/get-block-offers',
        'tour/promotional-tour' => 'tour/promotional-tour',
        'tour/get-hotel-review' => 'tour/get-hotel-review',
        'tour/get-hotel-review-info' => 'tour/get-hotel-review-info',
        'tour/<country:[\w- ]+>' => 'search/index',
        'tour/<country:[\w- ]+>/<city:[\w-:]+>' => 'search/index',
        'tour/<country:[\w- ]+>/<city:[\w-:]+>/<tour:[\w-]+>' => 'tour/index',
        'vacancy/notificator' => 'vacancy/notificator',
        '' => 'site/index',
//        'contact' => 'contact/index',
//        'signup' => 'auth/signup/request',
//        'signup/<_a:[\w-]+>' => 'auth/signup/<_a>',
//        '<_a:login|logout>' => 'auth/auth/<_a>',

        ['class' => 'frontend\urls\BlogCountryUrlRule'],
        ['class' => 'frontend\urls\BlogHotelUrlRule'],
        ['class' => 'frontend\urls\BlogCategoryUrlRule'],
        ['class' => 'frontend\urls\BlogTagUrlRule'],
        ['class' => 'frontend\urls\BlogPostUrlRule'],
        ['class' => 'frontend\urls\FaqUrlRule'],
//        'blog' => 'blog/post/index',
//        'blog/tag/<slug:[\w\-]+>' => 'blog/post/tag',
//        'blog/<id:\d+>' => 'blog/post/post',
//        'blog/<id:\d+>/comment' => 'blog/post/comment',
//        'blog/<slug:[\w\-]+>' => 'blog/post/category',
//        'cabinet' => 'cabinet/order/index',
        'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
//        'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
//        'cabinet/<_c:[\w\-]+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',
//        'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',
        [
            'class' => 'backend\modules\content\components\PageRule',
            'connectionID' => 'db',
        ],
        'print' => 'tour/print',
    ],
];
