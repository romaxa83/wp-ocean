<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dispatch_notifications`.
 */
class m181206_094911_create_dispatch_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dispatch_notifications}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'text' => $this->text(),
            'variables' => $this->string(1000),
            'status' => $this->boolean()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{dispatch_notifications}}');
    }
}
