<?php

use yii\db\Migration;

/**
 * Class m190822_131854_add_data_for_tour_pages
 */
class m190822_131854_add_data_for_tour_pages extends Migration {

    public $page = [
        ['type' => 'exotic_page', 'alias' => 'exotic-tours', 'title' => 'Экзотические туры'],
        ['type' => 'sale_page', 'alias' => 'sale-tours', 'title' => 'Топ продаж'],
        ['type' => 'hot_page', 'alias' => 'hot-tours', 'title' => 'Горящие туры']
    ];

    public function safeUp() {
        foreach ($this->page as $v) {
            $this->insert('slug_manager', [
                'slug' => $v['alias'],
                'route' => 'tour-page/index',
                'template' => 'tour_page'
            ]);
            $slug = Yii::$app->db->createCommand('SELECT id FROM slug_manager ORDER BY id DESC LIMIT 1')->queryOne();
            $this->insert('page', [
                'title' => $v['title'],
                'slug_id' => $slug['id'],
                'creation_date' => date('Y-m-d'),
                'modification_date' => date('Y-m-d'),
            ]);
            $page = Yii::$app->db->createCommand('SELECT id FROM page ORDER BY id DESC LIMIT 1')->queryOne();
            $this->insert('page_meta', [
                'page_id' => $page['id'],
                'title' => $v['title'],
                'description' => $v['title'],
                'keywords' => $v['title']
            ]);
            $this->insert('page_text', [
                'page_id' => $page['id'],
                'name' => 'data_type',
                'label' => 'Тип данных',
                'type' => 'string',
                'text' => $v['type']
            ]);
            $this->insert('page_text', [
                'page_id' => $page['id'],
                'name' => 'filter',
                'label' => 'Фильтр',
                'type' => 'filter',
                'text' => NULL
            ]);
            $this->insert('page_text', [
                'page_id' => $page['id'],
                'name' => 'description',
                'label' => 'Описание',
                'type' => 'editor',
                'text' => $v['title']
            ]);
        }
    }

    public function safeDown() {
        foreach ($this->page as $v) {
            $page = Yii::$app->db->createCommand("SELECT id, slug_id FROM page WHERE title = '" . $v['title'] . "'")->queryOne();
            Yii::$app->db->createCommand()->delete('page_text', ['page_id' => $page['id']])->execute();
            Yii::$app->db->createCommand()->delete('page_meta', ['page_id' => $page['id']])->execute();
            Yii::$app->db->createCommand()->delete('page', ['id' => $page['id']])->execute();
            Yii::$app->db->createCommand()->delete('slug_manager', ['id' => $page['slug_id']])->execute();
        }
    }

}
