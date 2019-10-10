<?php

namespace backend\modules\content\migrations\projectMigrations;

use Yii;
use yii\db\Migration;

/**
 * Class M190408062627DirectionsPageContent
 */
class M190408062627DirectionsPageContent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('slug_manager', [
            'slug' => 'napravlenia',
            'route' => 'direction/index',
            'template' => 'directions'
        ]);

        $slug_id = Yii::$app->db->createCommand('SELECT id FROM slug_manager ORDER BY id DESC LIMIT 1')->queryOne();
        $slug_id = $slug_id['id'];

        $this->insert('seo_data', [
            'title' => 'Направления',
            'description' => 'Направления',
        ]);

        $seo_id = Yii::$app->db->createCommand('SELECT id FROM seo_data ORDER BY id DESC LIMIT 1')->queryOne();
        $seo_id = $seo_id['id'];

        $record_structure = 'a:10:{i:0;a:3:{s:4:"name";s:2:"h1";s:5:"label";s:18:"Заголовок";s:4:"type";s:6:"string";}' .
            'i:10;a:3:{s:4:"name";s:10:"background";s:5:"label";s:21:"Фон фильтра";s:4:"type";s:5:"image";}i:11;' .
            'a:3:{s:4:"name";s:15:"hot_tours_title";s:5:"label";s:44:"Заголовок горящих туров";s:4:"type";s:6:"string";}' .
            'i:12;a:3:{s:4:"name";s:18:"best_resorts_title";s:5:"label";s:48:"Заголовок лучших курортов";s:4:"type";s:6:"string";}' .
            'i:13;a:3:{s:4:"name";s:19:"information_in_blog";s:5:"label";s:49:"Заголовок вырезки из блога";s:4:"type";s:6:"string";}' .
            'i:14;a:3:{s:4:"name";s:14:"seo_text_title";s:5:"label";s:35:"Заголовок SEO текста";s:4:"type";s:6:"string";}' .
            'i:15;a:3:{s:4:"name";s:8:"seo_text";s:5:"label";s:14:"SEO текст";s:4:"type";s:6:"editor";}i:7;a:3:{s:4:"name";' .
            's:14:"api_country_id";s:5:"label";s:21:"Страна из API";s:4:"type";s:20:"api-country-selector";}i:8;' .
            'a:3:{s:4:"name";s:7:"resorts";s:5:"label";s:14:"Курорты";s:4:"type";s:7:"resorts";}i:9;a:3:{s:4:"name";' .
            's:15:"tab_information";s:5:"label";s:37:"Полезная информация";s:4:"type";s:5:"cards";}}';

        $this->insert('channel', [
            'title' => 'Направления',
            'route_id' => $slug_id,
            'seo_id' => $seo_id,
            'record_structure' => $record_structure,
            'status' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $channel_id = Yii::$app->db->createCommand('SELECT id FROM channel ORDER BY id DESC LIMIT 1')->queryOne();
        $channel_id = $channel_id['id'];

        $columns = array('channel_id', 'name', 'label', 'type', 'content');

        $this->batchInsert('channel_records_common_field', $columns, [
            [
                'channel_id' => $channel_id,
                'name' => 'section_title_1',
                'label' => 'Заголовок секции 1',
                'type' => 'string',
                'content' => '5 океан рекомендуют'
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'form_title',
                'label' => 'Заголовок формы',
                'type' => 'string',
                'content' => 'отправьте заявку на подбор тура'
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'tab_information_title',
                'label' => 'Заголовок блока информации в табах',
                'type' => 'string',
                'content' => 'полезная информация'
            ],
        ]);

        $content = "<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, " .
            "Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. </p>";

        $this->batchInsert('channel_content', $columns, [
            [
                'channel_id' => $channel_id,
                'name' => 'h1',
                'label' => 'Заголовок',
                'type' => 'string',
                'content' => 'Наши направления'
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'section_title_1',
                'label' => 'Заголовок секции 1',
                'type' => 'string',
                'content' => '5 океан рекомендуют'
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'section_title_2',
                'label' => 'Заголовок секции 2',
                'type' => 'string',
                'content' => 'Отправьте заявку на подбор тура'
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'section_title_3',
                'label' => 'Заголовок секции 3',
                'type' => 'string',
                'content' => 'Заголовок СЕО текста'
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'section_content_3',
                'label' => 'Контент секции 3',
                'type' => 'editor',
                'content' => $content
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'section_title_4',
                'label' => 'Заголовок секции 4',
                'type' => 'string',
                'content' => 'Популярные места отдыха'
            ],
            [
                'channel_id' => $channel_id,
                'name' => 'popular_category',
                'label' => 'Категория популярных направлений',
                'type' => 'categories',
                'content' => '1'
            ],
        ]);

        $columns = array('channel_id', 'title', 'status', 'created_at');

        $this->batchInsert('channel_category', $columns, [
            [
                'channel_id' => $channel_id,
                'title' => 'Популярные',
                'status' => 1,
                'created_at' => date('Y-m-d')
            ],
            [
                'channel_id' => $channel_id,
                'title' => 'Европа',
                'status' => 1,
                'created_at' => date('Y-m-d')
            ],
            [
                'channel_id' => $channel_id,
                'title' => 'Азия',
                'status' => 1,
                'created_at' => date('Y-m-d')
            ],
            [
                'channel_id' => $channel_id,
                'title' => 'Сев. Америка',
                'status' => 1,
                'created_at' => date('Y-m-d')
            ],
            [
                'channel_id' => $channel_id,
                'title' => 'Юж. Америка',
                'status' => 1,
                'created_at' => date('Y-m-d')
            ],
            [
                'channel_id' => $channel_id,
                'title' => 'Австралия',
                'status' => 1,
                'created_at' => date('Y-m-d')
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M190408062627DirectionsPageContent cannot be reverted.\n";
    }
}
