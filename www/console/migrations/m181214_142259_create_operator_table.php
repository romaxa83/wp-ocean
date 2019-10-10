<?php

use yii\db\Migration;

/**
 * Handles the creation of table `operator`.
 */
class m181214_142259_create_operator_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('operator', [
            'id' => $this->primaryKey(),
            'oid' => $this->integer(),
            'name' => $this->string(),
            'url' => $this->string(),
            'countries' => $this->text(),
            'currencies' => $this->text(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'sync' => $this->boolean()->defaultValue(TRUE)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('operator');
    }

}
