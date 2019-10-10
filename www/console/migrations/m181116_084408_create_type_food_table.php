<?php

use yii\db\Migration;

/**
 * Handles the creation of table `type_food`.
 */
class m181116_084408_create_type_food_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('type_food', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'description' => $this->text(),
            'position' => $this->integer(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'sync' => $this->boolean()->defaultValue(TRUE)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('type_food');
    }

}
