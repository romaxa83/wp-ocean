<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dispatch_job`.
 */
class m181205_123833_create_dispatch_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dispatch_job}}', [
            'id' => $this->primaryKey(),
            'dispatch_id' => $this->integer()->notNull(),
            'letter_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dispatch_job}}');
    }
}
