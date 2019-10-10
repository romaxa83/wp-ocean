<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hotel`.
 */
class m181119_134540_create_hotel_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('hotel', [
            'id' => $this->primaryKey(),
            'hid' => $this->integer(),
            'media_id' => $this->integer(),
            'country_id' => $this->integer(),
            'city_id' => $this->integer(),
            'category_id' => $this->integer(),
            'type_id' => $this->integer(),
            'view_id' => $this->integer(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'gallery' => $this->text(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'sync' => $this->boolean()->defaultValue(TRUE)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('hotel');
    }

}
