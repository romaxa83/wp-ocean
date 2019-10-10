<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transport`.
 */
class m181113_090433_create_transport_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('transport', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'status' => $this->boolean()->defaultValue(TRUE)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('transport');
    }

}
