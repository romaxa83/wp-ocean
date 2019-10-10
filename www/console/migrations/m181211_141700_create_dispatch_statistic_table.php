<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dispatch_statistic`.
 */
class m181211_141700_create_dispatch_statistic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dispatch_statistic}}', [
            'id' => $this->primaryKey(),
            'letter_id' => $this->integer()->notNull(),
            'all' => $this->integer(),
            'sended' => $this->integer(),
            'start_time' => $this->integer(),
            'end_time' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-dispatch_statistic-send}}', '{{%dispatch_statistic}}', 'letter_id');

        $this->addForeignKey('{{%fk-dispatch_statistic-letter}}', '{{%dispatch_statistic}}', 'letter_id', '{{%dispatch_letter}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-dispatch_statistic-letter}}', '{{%dispatch_statistic}}');

        $this->dropTable('{{%dispatch_statistic}}');
    }
}
