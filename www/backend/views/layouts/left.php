<?php

use backend\modules\vacancyNotification\models\VacancyNotification;

$access = new backend\modules\user\useCase\Access();
$access->accessInView('blog/hotel-review/index');
$vacancyCount = VacancyNotification::getCount();
$vacancyClass = $vacancyCount ? '' : 'hidden';
$notificationCount = $vacancyCount;
$notificationClass = $notificationCount ? '' : 'hidden';

?>
<aside class="main-sidebar">

    <section class="sidebar">
        <!-- search form -->
        <!--        <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Поиск..."/>
                        <span class="input-group-btn">
                            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>-->
        <!-- /.search form -->
        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
//                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                        ['label' => 'Блог', 'icon' => 'pencil', 'url' => '#',
                            'items' => [
                                ['label' => 'Категории', 'icon' => 'circle', 'url' => ['/blog/category/index'],'visible' => $access->accessInView('blog/category/index')],
                                ['label' => 'Теги', 'icon' => 'circle', 'url' => ['/blog/tag/index'],'visible' => $access->accessInView('blog/tag/index')],
                                ['label' => 'Посты', 'icon' => 'circle', 'url' => ['/blog/post/index'],'visible' => $access->accessInView('blog/post/index')],
                                ['label' => 'Обзор отелей', 'icon' => 'circle', 'url' => ['/blog/hotel-review/index'],'visible' => $access->accessInView('blog/hotel-review/index')],
                                ['label' => 'Отзывы по отелям', 'icon' => 'circle', 'url' => ['/blog/review/index'],'visible' => $access->accessInView('blog/review/index')],
                            ],'visible' => $access->accessForMenu('blog')],
                        ['label' => 'Справочники', 'icon' => 'list-alt', 'url' => '#',
                            'items' => [
                                ['label' => 'Страны', 'icon' => 'list-alt', 'url' => ['/referenceBooks/country'],'visible' => $access->accessInView('referenceBooks/country/index')],
                                ['label' => 'Города', 'icon' => 'list-alt', 'url' => ['/referenceBooks/city'],'visible' => $access->accessInView('referenceBooks/city/index')],
                                //['label' => 'Развлечения', 'icon' => 'list-alt', 'url' => ['/referenceBooks/entertainment'],'visible' => $access->accessInView('blog/entertainment/index')],
                                ['label' => 'Тип туров', 'icon' => 'list-alt', 'url' => ['/referenceBooks/type-tour'],'visible' => $access->accessInView('referenceBooks/type-tour/index')],
                                ['label' => 'Тип отелей', 'icon' => 'list-alt', 'url' => ['/referenceBooks/type-hotel'],'visible' => $access->accessInView('referenceBooks/type-hotel/index')],
                                ['label' => 'Тип транспорта', 'icon' => 'list-alt', 'url' => ['/referenceBooks/transport'],'visible' => $access->accessInView('referenceBooks/transport/index')],
                                ['label' => 'Тип питания', 'icon' => 'list-alt', 'url' => ['/referenceBooks/type-food'],'visible' => $access->accessInView('referenceBooks/type-food/index')],
                                ['label' => 'Отели', 'icon' => 'list-alt', 'url' => ['/referenceBooks/hotel'],'visible' => $access->accessInView('referenceBooks/hotel/index')],
                                ['label' => 'Города вылета', 'icon' => 'list-alt', 'url' => ['/referenceBooks/dept-city'],'visible' => $access->accessInView('referenceBooks/dept-city/index')],
                                ['label' => 'Пакетные туры', 'icon' => 'list-alt', 'url' => ['/referenceBooks/tour'],'visible' => $access->accessInView('referenceBooks/tour/index')],
                                ['label' => 'Операторы', 'icon' => 'list-alt', 'url' => ['/referenceBooks/operator'],'visible' => $access->accessInView('referenceBooks/operator/index')],
                            ],'visible' => $access->accessForMenu('referenceBooks')],
                        ['label' => 'Пользователи', 'icon' => 'users', 'url' => '#',
                            'items' => [
                                ['label' => 'Пользователи', 'icon' => 'circle', 'url' => ['/user/user/index'],'visible' => $access->accessInView('user/user/index')],
//                                ['label' => 'Отзывы', 'icon' => 'circle', 'url' => ['/user/reviews/index'],'visible' => $access->accessInView('user/reviews/index')],
//                                ['label' => 'Роли и разрешения', 'icon' => 'circle', 'url' => ['/user/rbac/index'],'visible' => $access->accessInView('user/rbac/index')],
                            ],'visible' => $access->accessForMenu('user')],
                        ['label' => 'F.A.Q.', 'icon' => 'question-circle', 'url' => '#',
                            'items' => [
                                ['label' => 'Категории', 'icon' => 'circle', 'url' => ['/faq/category/index'],'visible' => $access->accessInView('faq/category/index')],
                                ['label' => 'F.A.Q.', 'icon' => 'circle', 'url' => ['/faq/faq/index'],'visible' => $access->accessInView('faq/faq/index')],
                            ],'visible' => $access->accessForMenu('faq')],
                        ['label' => 'Рассылка', 'icon' => 'envelope', 'url' => '#',
                            'items' => [
//                                ['label' => 'Информационая рассылка', 'icon' => 'circle', 'url' => ['/dispatch/news-letter/index'],'visible' => $access->accessInView('dispatch/news-letter/index')],
//                                ['label' => 'Подписчики', 'icon' => 'circle', 'url' => ['/dispatch/subscriber/index'],'visible' => $access->accessInView('dispatch/subscriber/index')],
                                ['label' => 'Технические уведомления', 'icon' => 'circle', 'url' => ['/dispatch/notifications/index'],'visible' => $access->accessInView('dispatch/notifications/index')],
                            ],'visible' => $access->accessForMenu('dispatch')],
                        ['label' => 'Статические блоки', 'icon' => 'list', 'url' => '#',
                            'items' => [
                                ['label' => 'Преимущества', 'icon' => 'circle', 'url' => ['/staticBlocks/advantage/index'],'visible' => $access->accessInView('staticBlocks/advantage/index')],
                                ['label' => 'Smart рассылка', 'icon' => 'circle', 'url' => ['/staticBlocks/smart/index'],'visible' => $access->accessInView('staticBlocks/smart/index')],
                                ['label' => 'Счетчик', 'icon' => 'circle', 'url' => ['/staticBlocks/counter/index'],'visible' => $access->accessInView('staticBlocks/counter/index')],
                                ['label' => 'Seo', 'icon' => 'circle', 'url' => ['/staticBlocks/seo/index'],'visible' => $access->accessInView('staticBlocks/seo/index')],
                                ['label' => 'О компании', 'icon' => 'circle', 'url' => ['/staticBlocks/company/index'],'visible' => $access->accessInView('staticBlocks/company/index')],
                            ],'visible' => $access->accessForMenu('staticBlocks')],
                        [
                            'label' => 'Уведомления',
                            'icon' => 'bell',
                            'url' => '#',
                            'template'=>'<a href="{url}">{icon} {label}<span class="pull-right-container ' . $notificationClass . '">' .
                                '<small class="label pull-right bg-green">' . $notificationCount . '</small></span>' .
                                '</a>',
                            'items' => [
                                [
                                    'label' => 'По вакансиям',
                                    'icon' => 'user-plus',
                                    'url' => ['/vacancy-notification'],
                                    'visible' => $access->accessInView('/vacancy-notification'),
                                    'template'=>'<a href="{url}">{icon} {label}<span class="pull-right-container ' . $vacancyClass . '">' .
                                        '<small class="label pull-right bg-blue ">' . $vacancyCount . '</small></span>' .
                                        '</a>',
                                ]
                            ]
                        ],
                        ['label' => 'Заказы туров', 'icon' => 'question-circle', 'url' => ['/order/order/index'],'visible' => $access->accessInView('order/order/index')],
                        ['label' => 'Заявки', 'icon' => 'question-circle', 'url' => ['/request/request/index'],'visible' => $access->accessInView('request/request/index')],
                        ['label' => 'Акции', 'icon' => 'question-circle', 'url' => ['/specials/specials/index'],'visible' => $access->accessInView('specials/specials/index')],
                        [
                            'label' => 'Контент',
                            'icon' => 'briefcase',
                            'url' => '#',
                            'items' =>
                            [
                                ['label' => 'Страницы', 'icon' => 'file-o', 'url' => ['/content/page'], 'visible' => $access->accessInView('/content/page')],
                                ['label' => 'Типы записей', 'icon' => 'archive', 'url' => ['/content/channel'], 'visible' => $access->accessInView('/content/channel')],
                                ['label' => 'Настройки', 'icon' => 'gear', 'url' => ['/content/options'], 'visible' => $access->accessInView('/content/options')],
                            ],
                            'visible' => $access->accessForMenu('content')
                        ],
                        ['label' => 'Редактор меню', 'icon'=> 'bars', 'url' => ['/menuBuilder/menu'], 'visible' => $access->accessInView('/menuBuilder/menu')],
                        ['label' => 'SEO поиск', 'icon' => 'question-circle', 'url' => ['/seoSearch/seo-search']],
                        ['label' => 'Фильтр', 'icon' => 'question-circle', 'url' => ['/filter/filter'], 'visible' => $access->accessInView('/filter/filter/index')],
                        ['label' => 'Настройки', 'icon' => 'question-circle', 'url' => ['/settings/settings/index'],'visible' => $access->accessInView('/settings/settings/index')],
                        [
                            'label' => 'Инструменты',
                            'icon' => 'share',
                            'url' => '#',
                            'visible' => YII_ENV_PROD ? false : true,
                            'items' => [
                                ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                                ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                                [
                                    'label' => 'Level One',
                                    'icon' => 'circle-o',
                                    'url' => '#',
                                    'items' => [
                                        ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                        [
                                            'label' => 'Level Two',
                                            'icon' => 'circle-o',
                                            'url' => '#',
                                            'items' => [
                                                ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                                ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
        )
        ?>
    </section>
</aside>
