<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%specials}}`.
 */
class m190425_115953_create_specials_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%specials}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'from_datetime' => $this->dateTime()->notNull(),
            'to_datetime' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%specials}}');
    }
}
