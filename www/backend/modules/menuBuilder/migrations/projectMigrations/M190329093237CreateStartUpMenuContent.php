<?php

namespace backend\modules\menuBuilder\migrations\projectMigrations;

use Yii;
use yii\db\Migration;

/**
 * Class M190329093237CreateStartUpMenuContent
 */
class M190329093237CreateStartUpMenuContent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $columns = array('parent_id', 'menu_id', 'type', 'title', 'data', 'position', 'status');

        // Create main menu
        $this->insert('menu', [
            'name' => 'main',
            'label' => 'Главное меню',
        ]);

        $menu_id = Yii::$app->db->createCommand('SELECT id FROM menu ORDER BY id DESC LIMIT 1')->queryOne();
        $menu_id = $menu_id['id'];

        $this->batchInsert('menu_item', $columns, [
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'В разработке',
                'data' => '{"template":"in-development"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'Страницы',
                'data' => '{"template":"general"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'Телефоны',
                'data' => '{"template":"general"}',
                'position' => 3,
                'status' => 1
            ]
        ]);

        $item_id = Yii::$app->db->createCommand('SELECT id FROM menu_item ORDER BY id DESC LIMIT 1')->queryOne();

        $phonesId = $item_id['id'];
        $pagesId = $phonesId - 1;
        $inDevelopmentId = $pagesId - 1;

        $this->batchInsert('menu_item', $columns, [
            [
                'parent_id' => $inDevelopmentId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Горящие туры',
                'data' => '{"link":"#"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $inDevelopmentId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Раннее бронирование 2019',
                'data' => '{"link":"#"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $inDevelopmentId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Экзотические туры',
                'data' => '{"link":"#"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => $pagesId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'Блог',
                'data' => '{"route":"/blog"}',
                'position' => 4,
                'status' => 1
            ],
            [
                'parent_id' => $pagesId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'Главная',
                'data' => '{"route":"/","template":"main"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $pagesId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'О Компании',
                'data' => '{"route":"team/index","template":"about-us"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $pagesId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'Работа в компании',
                'data' => '{"route":"vacancy/index","template":"vacancy-index"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => $pagesId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'Контакты',
                'data' => '{"route":"contact/index","template":"contacts"}',
                'position' => 5,
                'status' => 1
            ],
            [
                'parent_id' => $phonesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => '+38 (050) 50 34 656',
                'data' => '{"link":"tel:380505034656"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $phonesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => '(0552) 422 562',
                'data' => '{"link":"tel:0552422562"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $phonesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => '(0552) 422 282 (Viber, WhatsApp)',
                'data' => '{"link":"tel:0552422282"}',
                'position' => 2,
                'status' => 1
            ],
        ]);

        // Create footer menu
        $this->insert('menu', [
            'name' => 'footer-menu',
            'label' => 'Нижнее меню',
        ]);

        $menu_id = Yii::$app->db->createCommand('SELECT id FROM menu ORDER BY id DESC LIMIT 1')->queryOne();
        $menu_id = $menu_id['id'];

        $this->batchInsert('menu_item', $columns, [
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'Категории',
                'data' => '{"template":"in-development-footer"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'Туры',
                'data' => '{"template":"in-development-footer"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'Страны',
                'data' => '{"template":"countries-footer"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'О компании',
                'data' => '{"template":"footer-section"}',
                'position' => 4,
                'status' => 1
            ],
            [
                'parent_id' => 0,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'Контакты',
                'data' => '{"template":"footer-section"}',
                'position' => 5,
                'status' => 1
            ],
        ]);

        $item_id = Yii::$app->db->createCommand('SELECT id FROM menu_item ORDER BY id DESC LIMIT 1')->queryOne();
        $contactsId = $item_id['id'];
        $aboutUsId = $contactsId - 1;
        $countriesId = $aboutUsId - 1;
        $toursId = $countriesId - 1;
        $categoriesId = $toursId - 1;

        $this->batchInsert('menu_item', $columns, [
            [
                'parent_id' => $categoriesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Горящие туры',
                'data' => '{"link":"#"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $categoriesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Раннее бронирование 2019',
                'data' => '{"link":"#"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $categoriesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Экзотические туры',
                'data' => '{"link":"#"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => $toursId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Авиа туры',
                'data' => '{"link":"#"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $toursId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Автобусные туры',
                'data' => '{"link":"#"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $toursId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Акционные туры',
                'data' => '{"link":"#"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => $countriesId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'Поиск',
                'data' => '{"route":"/search"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $countriesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Направления',
                'data' => '{"link":"#"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $countriesId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => 'Отзывы',
                'data' => '{"link":"#"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => $aboutUsId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'Блог',
                'data' => '{"route":"/blog"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $aboutUsId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'О Компании',
                'data' => '{"route":"team/index","template":"about-us"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $aboutUsId,
                'menu_id' => $menu_id,
                'type' => 'route',
                'title' => 'Контакты',
                'data' => '{"route":"contact/index","template":"contacts"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => $contactsId,
                'menu_id' => $menu_id,
                'type' => 'link',
                'title' => '+38 (050) 50 34 656',
                'data' => '{"link":"tel:380505034656"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $contactsId,
                'menu_id' => $menu_id,
                'type' => 'group',
                'title' => 'Социальные сети',
                'data' => '{"template":"social-footer"}',
                'position' => 2,
                'status' => 1
            ],
        ]);

        $item_id = Yii::$app->db->createCommand('SELECT id FROM menu_item ORDER BY id DESC LIMIT 1')->queryOne();
        $socialsId = $item_id['id'];

        $this->batchInsert('menu_item', $columns, [
            [
                'parent_id' => $socialsId,
                'menu_id' => $menu_id,
                'type' => 'social',
                'title' => 'Facebook',
                'data' => '{"icon":"icon-facebook","link":"https://www.facebook.com/5okean"}',
                'position' => 1,
                'status' => 1
            ],
            [
                'parent_id' => $socialsId,
                'menu_id' => $menu_id,
                'type' => 'social',
                'title' => 'Instagram',
                'data' => '{"icon":"icon-instagram","link":"https://www.instagram.com/5_okean"}',
                'position' => 2,
                'status' => 1
            ],
            [
                'parent_id' => $socialsId,
                'menu_id' => $menu_id,
                'type' => 'social',
                'title' => 'YouTube',
                'data' => '{"icon":"icon-youtube","link":"https://www.youtube.com/channel/UCYMl_xKoHYbbZdovl06Clpw"}',
                'position' => 3,
                'status' => 1
            ],
            [
                'parent_id' => $socialsId,
                'menu_id' => $menu_id,
                'type' => 'social',
                'title' => 'Telegram',
                'data' => '{"icon":"icon-telegram","link":"https://t.me/ta5okean"}',
                'position' => 4,
                'status' => 1
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M190329093237CreateStartUpMenuContent cannot be reverted.\n";
    }
}
