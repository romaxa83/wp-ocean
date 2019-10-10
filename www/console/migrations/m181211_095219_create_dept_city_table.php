<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dept_city`.
 */
class m181211_095219_create_dept_city_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('dept_city', [
            'id' => $this->primaryKey(),
            'cid' => $this->integer(),
            'name' => $this->string(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'sync' => $this->boolean()->defaultValue(TRUE),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('dept_city');
    }

}
