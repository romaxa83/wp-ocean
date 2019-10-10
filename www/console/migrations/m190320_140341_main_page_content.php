<?php

use yii\db\Migration;

/**
 * Class m190320_140341_main_page_content
 */
class m190320_140341_main_page_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('slug_manager', [
            'slug' => 'glavnaa',
            'route' => '/',
            'template' => 'main'
        ]);

        $slug_id = Yii::$app->db->createCommand('SELECT id FROM slug_manager ORDER BY id DESC LIMIT 1')->queryOne();
        $slug_id = $slug_id['id'];

        $this->insert('page', [
            'title' => 'Главная',
            'slug_id' => $slug_id,
            'creation_date' => date('Y-m-d'),
            'modification_date' => date('Y-m-d'),
        ]);

        $page_id = Yii::$app->db->createCommand('SELECT id FROM page ORDER BY id DESC LIMIT 1;')->queryOne();
        $page_id = $page_id['id'];

        $this->insert('page_meta', [
            'page_id' => $page_id,
            'title' => 'Пятый океан',
            'description' => 'Пятый океан',
            'keywords' => ''
        ]);



        $banners = 'a:3:{i:0;a:5:{s:4:"name";s:23:"Горящие туры";s:11:"description";s:55:"Спешите заказать прямо сейчас";' .
            's:6:"filter";s:1:"1";s:5:"image";s:6:"380525";s:5:"bluer";s:6:"380524";}i:1;' .
            'a:5:{s:4:"name";s:42:"Раннее бронирование 2019";s:11:"description";s:57:"Откройте новый мир впечатлений";' .
            's:6:"filter";s:1:"2";s:5:"image";s:6:"380527";s:5:"bluer";s:6:"380526";}i:2;a:5:{s:4:"name";s:33:"Экзотические туры";s:11:"description";' .
            's:54:"Самые изысканные предложения";s:6:"filter";s:1:"1";s:5:"image";s:6:"380528";s:5:"bluer";s:6:"380529";}}';

        $this->insert('page_text', [
            'page_id' => $page_id,
            'name' => 'banners',
            'label' => 'Баннеры',
            'type' => 'banners',
            'text' => $banners
        ]);

        $this->insert('content_options', [
            'name' => 'main_page_id',
            'value' => $page_id
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190320_140341_main_page_content cannot be reverted.\n";
    }
}
