<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m190209_095527_create_order_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'date' => $this->dateTime(),
            'offer' => $this->string(),
            'name' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'comment' => $this->string(),
            'price' => $this->decimal(65, 4),
            'status' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%order}}');
    }

}
