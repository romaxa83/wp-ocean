<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seo_search}}`.
 */
class m190314_122049_create_seo_search_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%seo_search}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(),
            'dept_city_id' => $this->integer(),
            'city_id' => $this->integer(),
            'status' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%seo_search}}');
    }

}
