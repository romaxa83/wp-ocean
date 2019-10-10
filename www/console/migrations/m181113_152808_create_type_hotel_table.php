<?php

use yii\db\Migration;

/**
 * Handles the creation of table `type_hotel`.
 */
class m181113_152808_create_type_hotel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%type_hotel}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'description' => $this->text(),
            'media_id' => $this->integer(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'sync' => $this->boolean()->defaultValue(TRUE),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%type_hotel}}');
    }
}
