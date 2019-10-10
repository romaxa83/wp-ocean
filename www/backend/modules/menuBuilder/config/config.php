<?php

use yii\helpers\Url;

return [
    'params' => [
        'itemTypes' => [
            Url::to('admin/menuBuilder/item-type/get-group', true) => 'Группирующий элемент',
            Url::to('admin/menuBuilder/item-type/get-page', true) => 'Страница',
            Url::to('admin/menuBuilder/item-type/get-channel', true) => 'Канал',
            Url::to('admin/menuBuilder/item-type/get-filter', true) => 'Фильтр',
            Url::to('admin/menuBuilder/item-type/get-blog', true) => 'Блог',
            Url::to('admin/menuBuilder/item-type/get-faq', true) => 'FAQ',
            Url::to('admin/menuBuilder/item-type/get-social', true) => 'Социальная сеть',
            Url::to('admin/menuBuilder/item-type/get-link', true) => 'Ссылка',
        ],
        'groupTemplates' => [
            'in-development' => 'В разработке',
            'in-development-footer' => 'В разработке (нижнее)',
            'countries-footer' => 'Страны (нижнее)',
            'social-footer' => 'Социальные сети',
            'general' => 'Секция главного меню',
            'footer-section' => 'Секция нижнего меню'
        ]
    ],
];