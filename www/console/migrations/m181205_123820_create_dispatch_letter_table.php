<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dispatch_letter`.
 */
class m181205_123820_create_dispatch_letter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dispatch_letter}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(),
            'body' => 'MEDIUMTEXT',
            'status' => $this->boolean()->notNull()->defaultValue(false),
            'send' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dispatch_letter}}');
    }
}
