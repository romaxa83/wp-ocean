<?php

use yii\db\Migration;

/**
 * Class m181127_073321_create_user_passport_assignments
 */
class m181127_073321_create_user_passport_assignments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            $this->createTable('{{%user_passport_assignments}}', [
                'user_id' => $this->integer()->notNull(),
                'passport_int_id' => $this->integer()->notNull(),
            ], $tableOptions);

            $this->addPrimaryKey('{{%pk-user_passport_assignments}}', '{{%user_passport_assignments}}', ['user_id', 'passport_int_id']);

            $this->createIndex('{{%idx-user_passport_assignments-user_id}}', '{{%user_passport_assignments}}', 'user_id');
            $this->createIndex('{{%idx-user_passport_assignments-passport_id}}', '{{%user_passport_assignments}}', 'passport_int_id');

            $this->addForeignKey('{{%fk-user_passport_assignments-user_id}}', '{{%user_passport_assignments}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
            $this->addForeignKey('{{%fk-user_passport_assignments-passport_id}}', '{{%user_passport_assignments}}', 'passport_int_id', '{{%user_int_passport}}', 'id', 'CASCADE', 'RESTRICT');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-user_passport_assignments-user_id}}', '{{%user_passport_assignments}}');
        $this->dropForeignKey('{{%fk-user_passport_assignments-passport_id}}', '{{%user_passport_assignments}}');

        $this->dropTable('{{%user_passport_assignments}}');
    }
}
