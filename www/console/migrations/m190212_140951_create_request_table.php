<?php

use yii\db\Migration;

/**
 * Handles the creation of table `request`.
 */
class m190212_140951_create_request_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('request', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime(),
            'name' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'comment' => $this->string(),
            'status' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('request');
    }

}
