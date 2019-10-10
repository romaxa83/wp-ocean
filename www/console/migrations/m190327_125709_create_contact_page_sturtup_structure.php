<?php

use yii\db\Migration;

/**
 * Class m190327_125709_create_contact_page_sturtup_structure
 */
class m190327_125709_create_contact_page_sturtup_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('slug_manager', [
            'slug' => 'kontakty',
            'route' => 'contact/index',
            'template' => 'contacts'
        ]);

        $slug_id = Yii::$app->db->createCommand('SELECT id FROM slug_manager ORDER BY id DESC LIMIT 1')->queryOne();
        $slug_id = $slug_id['id'];

        $this->insert('page', [
            'title' => 'Контакты',
            'slug_id' => $slug_id,
            'creation_date' => date('Y-m-d'),
            'modification_date' => date('Y-m-d'),
        ]);

        $page_id = Yii::$app->db->createCommand('SELECT id FROM page ORDER BY id DESC LIMIT 1;')->queryOne();
        $page_id = $page_id['id'];

        $this->insert('page_meta', [
            'page_id' => $page_id,
            'title' => 'Контакты',
            'description' => 'Контакты',
            'keywords' => ''
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190327_125709_create_contact_page_sturtup_structure cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_125709_create_contact_page_sturtup_structure cannot be reverted.\n";

        return false;
    }
    */
}
