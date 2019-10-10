<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dispatch`.
 */
class m181205_123802_create_dispatch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dispatch}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'email' => $this->string(),
            'status' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-dispatch-user_id}}', '{{%dispatch}}', 'user_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dispatch}}');
    }
}
