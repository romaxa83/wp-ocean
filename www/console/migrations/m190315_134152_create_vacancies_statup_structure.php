<?php

use yii\db\Migration;

/**
 * Class m190315_134152_create_vacancies_statup_structure
 */
class m190315_134152_create_vacancies_statup_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // --------------------------------- Vacancy page. ------------------------------------------------------------
        $this->insert('slug_manager', [
            'slug' => 'vakansii',
            'route' => 'vacancy/index',
            'template' => 'vacancy-index',
        ]);

        $slug_id = Yii::$app->db->createCommand('SELECT id FROM slug_manager ORDER BY id DESC LIMIT 1')->queryOne();
        $slug_id = $slug_id['id'];

        $this->insert('seo_data', [
            'title' => 'Интересная работа в компании',
            'description' => 'Интересная работа в компании',
        ]);

        $seo_id = Yii::$app->db->createCommand('SELECT id FROM seo_data ORDER BY id DESC LIMIT 1')->queryOne();
        $seo_id = $seo_id['id'];

        $record_structure = 'a:13:{i:0;a:3:{s:4:"name";s:5:"title";s:5:"label";s:18:"Заголовок";s:4:"type";s:6:"string";}' .
            'i:10;a:3:{s:4:"name";s:18:"description_part_1";s:5:"label";s:33:"Описание столбец 1";s:4:"type";s:6:"editor";}' .
            'i:11;a:3:{s:4:"name";s:18:"description_part_2";s:5:"label";s:33:"Описание столбец 2";s:4:"type";s:6:"editor";}' .
            'i:12;a:3:{s:4:"name";s:10:"subtitle_1";s:5:"label";s:31:"Заголовок блока 1";s:4:"type";s:6:"string";}' .
            'i:13;a:3:{s:4:"name";s:7:"block_1";s:5:"label";s:10:"Блок 1";s:4:"type";s:6:"editor";}' .
            'i:14;a:3:{s:4:"name";s:10:"subtitle_2";s:5:"label";s:31:"Заголовок блока 2";s:4:"type";s:6:"string";}' .
            'i:15;a:3:{s:4:"name";s:7:"block_2";s:5:"label";s:10:"Блок 2";s:4:"type";s:6:"editor";}' .
            'i:16;a:3:{s:4:"name";s:10:"subtitle_3";s:5:"label";s:31:"Заголовок блока 3";s:4:"type";s:6:"string";}' .
            'i:17;a:3:{s:4:"name";s:7:"block_3";s:5:"label";s:10:"Блок 3";s:4:"type";s:6:"editor";}' .
            'i:18;a:3:{s:4:"name";s:10:"subtitle_4";s:5:"label";s:31:"Заголовок блока 4";s:4:"type";s:6:"string";}' .
            'i:19;a:3:{s:4:"name";s:7:"block_4";s:5:"label";s:10:"Блок 4";s:4:"type";s:6:"editor";}' .
            'i:20;a:3:{s:4:"name";s:10:"experience";s:5:"label";s:8:"Опыт";s:4:"type";s:6:"string";}' .
            'i:21;a:3:{s:4:"name";s:15:"section_title_2";s:5:"label";s:33:"Заголовок секции 2";s:4:"type";s:6:"string";}}';

        $this->insert('channel', [
            'title' => 'Вакансии',
            'route_id' => $slug_id,
            'seo_id' => $seo_id,
            'record_structure' => $record_structure,
            'status' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $channel_id = Yii::$app->db->createCommand('SELECT id FROM channel ORDER BY id DESC LIMIT 1')->queryOne();
        $channel_id = $channel_id['id'];

        $this->insert('channel_content', [
            'channel_id' => $channel_id,
            'name' => 'h1',
            'label' => 'Заголовок',
            'type' => 'string',
            'content' => 'Интересная работа в компании'
        ]);

        $content = "<p>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, " .
            "lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus " .
            "a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non  " .
            "mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. " .
            "Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. </p><ul class=\"list-wrap\">
                    <li>This is Photoshop's version  of Lorem Ipsum.</li>
                    <li>This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor </li>
                </ul>";

        $this->insert('channel_content', [
            'channel_id' => $channel_id,
            'name' => 'description_part_1',
            'label' => 'Описание столбец 1',
            'type' => 'editor',
            'content' => $content
        ]);

        $this->insert('channel_content', [
            'channel_id' => $channel_id,
            'name' => 'description_part_2',
            'label' => 'Описание столбец 2',
            'type' => 'editor',
            'content' => $content
        ]);

        $cards = "a:4:{i:0;a:3:{s:5:\"photo\";s:6:\"380522\";s:5:\"title\";s:12:\"Кто мы?\";s:11:\"description\";s:77:\"<p>Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus.</p>\";}i:1;a:3:{s:5:\"photo\";s:6:\"380523\";s:5:\"title\";s:36:\"Мы предлагаем успех\";s:11:\"description\";s:63:\"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\";}i:2;a:3:{s:5:\"photo\";s:6:\"380521\";s:5:\"title\";s:11:\"Lorem ipsum\";s:11:\"description\";s:95:\"<p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; </p>\";}i:3;a:3:{s:5:\"photo\";s:6:\"380520\";s:5:\"title\";s:15:\"Vestibulum ante\";s:11:\"description\";s:62:\"<p>Vivamus suscipit tortor eget felis porttitor volutpat. </p>\";}}";

        $this->insert('channel_content', [
            'channel_id' => $channel_id,
            'name' => 'cards',
            'label' => 'Карточки',
            'type' => 'cards',
            'content' => $cards
        ]);

        $this->insert('channel_content', [
            'channel_id' => $channel_id,
            'name' => 'section_title_3',
            'label' => 'Заголовок секции 3',
            'type' => 'string',
            'content' => 'факты о нашей работе'
        ]);

        $facts = 'a:4:{i:0;a:2:{s:5:"value";s:2:"50";s:11:"description";s:69:"высококвалифицированных сотрудников";}' .
            'i:1;a:2:{s:5:"value";s:3:"500";s:11:"description";s:37:"разнообразных туров";}i:2;a:2:{s:5:"value";s:2:"78";' .
            's:11:"description";s:61:"стран, которые мы лично проверили";}i:3;a:2:{s:5:"value";s:6:"20 000";' .
            's:11:"description";s:35:"довольных клиентов";}}';

        $this->insert('channel_content', [
            'channel_id' => $channel_id,
            'name' => 'facts',
            'label' => 'Факты о работе',
            'type' => 'statistics',
            'content' => $facts
        ]);

        $this->insert('channel_content', [
            'channel_id' => $channel_id,
            'name' => 'section_title_4',
            'label' => 'Заголовок секции 4',
            'type' => 'string',
            'content' => 'наши вакансии'
        ]);

        //---------------------------------------- Vacancy post --------------------------------------------------------
        $channel_slug_id = $slug_id;

        $this->insert('slug_manager', [
            'slug' => 'menedzer-po-turizmu',
            'route' => 'vacancy/view',
            'template' => 'vacancy-view',
            'parent_id' => $channel_slug_id
        ]);

        $slug_id = Yii::$app->db->createCommand('SELECT id FROM slug_manager ORDER BY id DESC LIMIT 1')->queryOne();
        $slug_id = $slug_id['id'];

        $this->insert('seo_data', [
            'title' => 'Менеджер по туризму',
            'description' => 'Менеджер по туризму',
            'keywords' => ''
        ]);

        $seo_id = Yii::$app->db->createCommand('SELECT id FROM seo_data ORDER BY id DESC LIMIT 1')->queryOne();
        $seo_id = $seo_id['id'];

        $this->insert('channel_record', [
            'channel_id' => $channel_id,
            'title' => 'Менеджер по туризму',
            'route_id' => $slug_id,
            'seo_id' => $seo_id,
            'status' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $channel_record_id = Yii::$app->db->createCommand('SELECT id FROM channel_record ORDER BY id DESC LIMIT 1')->queryOne();
        $channel_record_id = $channel_record_id['id'];

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'title',
            'label' => 'Заголовок',
            'type' => 'string',
            'content' => 'Менеджер по туризму'
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'description_part_1',
            'label' => 'Описание столбец 1',
            'type' => 'editor',
            'content' => $content
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'description_part_2',
            'label' => 'Описание столбец 2',
            'type' => 'editor',
            'content' => $content
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'subtitle_1',
            'label' => 'Заголовок блока 1',
            'type' => 'string',
            'content' => 'Что мы предлагаем:'
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'block_1',
            'label' => 'Блок 1',
            'type' => 'editor',
            'content' => $content
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'subtitle_2',
            'label' => 'Заголовок блока 2',
            'type' => 'string',
            'content' => 'Наши требования:'
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'block_2',
            'label' => 'Блок 2',
            'type' => 'editor',
            'content' => $content
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'subtitle_3',
            'label' => 'Заголовок блока 3',
            'type' => 'string',
            'content' => 'Обязанности менеджера'
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'block_3',
            'label' => 'Блок 3',
            'type' => 'editor',
            'content' => $content
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'subtitle_4',
            'label' => 'Заголовок блока 4',
            'type' => 'string',
            'content' => ''
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'block_4',
            'label' => 'Блок 4',
            'type' => 'editor',
            'content' => $content
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'experience',
            'label' => 'Опыт',
            'type' => 'string',
            'content' => 'Не требуется'
        ]);

        $this->insert('channel_record_content', [
            'channel_record_id' => $channel_record_id,
            'name' => 'section_title_2',
            'label' => 'Заголовок секции 2',
            'type' => 'string',
            'content' => 'похожие вакансии'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190315_134152_create_vacancies_statup_structure cannot be reverted.\n";

        return false;
    }
}
