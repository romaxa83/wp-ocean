<?php

use yii\db\Migration;

/**
 * Handles the creation of table `exchange_rate`.
 */
class m181117_132354_create_exchange_rate_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('exchange_rate', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'sign' => $this->string(),
            'name' => $this->string(),
            'status' => $this->boolean(),
            'sync' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('exchange_rate');
    }

}
