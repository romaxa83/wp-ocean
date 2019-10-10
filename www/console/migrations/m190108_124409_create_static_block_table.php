<?php

use yii\db\Migration;

/**
 * Handles the creation of table `static_block`.
 */
class m190108_124409_create_static_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%static_block}}', [
            'id' => $this->primaryKey(),
            'block' => $this->string(50)->notNull(),
            'alias' => $this->string(),
            'title' => $this->string(),
            'description' => $this->text(),
            'status' => $this->boolean()->defaultValue(false),
            'status_block' => $this->boolean()->defaultValue(true),
            'position' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%static_block}}');
    }
}
