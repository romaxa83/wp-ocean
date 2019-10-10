<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m181119_134937_create_service_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'type' => $this->string(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'sync' => $this->boolean()->defaultValue(TRUE)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('service');
    }

}
