<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%hotel_hash}}`.
 */
class m190521_090343_create_hotel_hash_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%hotel_hash}}', [
            'id' => $this->primaryKey(),
            'hid' => $this->integer()->notNull(),
            'country_id' => $this->integer(),
            'hash' => $this->string(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%hotel_hash}}');
    }
}
