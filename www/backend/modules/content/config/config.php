<?php

return [
    'params' => [
        'templates' => [
            'about-us' => [
                'route' => 'team/index',
                'label' => 'О нас'
            ],
            'vacancy-index' => [
                'route' => 'vacancy/index',
                'label' => 'Вакансии'
            ],
            'vacancy-view' => [
                'route' => 'vacancy/view',
                'label' => 'Вакансия'
            ],
            'main' => [
                'route' => '/',
                'label' => 'Главная'
            ],
            'contacts' => [
                'route' => 'contact/index',
                'label' => 'Контакты'
            ],
            'directions' => [
                'route' => 'direction/index',
                'label' => 'Направления'
            ],
            'direction' => [
                'route' => 'direction/view',
                'label' => 'Направление'
            ],
            'tour_page' => [
                'route' => 'tour-page/index',
                'label' => 'Страница тура'
            ]
        ],
        'blockTypes' => [
            'editor' => 'Редактор',
            'string' => 'Строка',
            'textarea' => 'Текстовая область',
            'team' => 'Команда',
            'cards' => 'Карточки',
            'statistics' => 'Статистика',
            'banners' => 'Баннеры',
            'image' => 'Изображение',
            'api-country-selector' => 'Страна из API',
            'resorts' => 'Курорты',
            'regions' => 'Регионы',
            'categories' => 'Категории',
            'filter' => 'Фильтр'
        ],
    ]
];
