<?php

use yii\db\Migration;

/**
 * Handles the creation of table `city`.
 */
class m181108_084037_create_city_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('city', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(),
            'cid' => $this->integer(),
            'position' => $this->integer()->defaultValue(0),
            'code' => $this->string(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'description' => $this->text(),
            'lat' => $this->decimal(65, 13),
            'lng' => $this->decimal(65, 13),
            'zoom' => $this->smallInteger(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'capital' => $this->boolean()->defaultValue(FALSE),
            'sync' => $this->boolean()->defaultValue(TRUE)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('city');
    }

}
