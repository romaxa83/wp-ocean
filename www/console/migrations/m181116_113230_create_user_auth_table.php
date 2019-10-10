<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_auth`.
 */
class m181116_113230_create_user_auth_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('{{%fk-auth-user_id-user-id}}', '{{%user_auth}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-auth-user_id-user-id}}', '{{%user_auth}}');
        $this->dropTable('{{%user_auth}}');
    }
}
