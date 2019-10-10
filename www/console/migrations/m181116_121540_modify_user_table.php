<?php

use yii\db\Migration;

/**
 * Class m181116_121540_modify_user_table
 */
class m181116_121540_modify_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}','username',$this->string());
        $this->addColumn('{{%user}}', 'passport_id', $this->integer()->after('username'));
        $this->addColumn('{{%user}}', 'passport_int_id', $this->integer()->after('passport_id'));
        $this->addColumn('{{%user}}', 'passport_rel_ids', $this->text()->after('passport_int_id'));
        $this->addColumn('{{%user}}', 'phone', $this->string(50)->after('email'));



        $this->createIndex('{{%idx-user-passport_id}}', '{{%user}}', 'passport_id');
        $this->createIndex('{{%idx-user-passport_int_id}}', '{{%user}}', 'passport_int_id');

        $this->addForeignKey('{{%fk-user-passport_id}}', '{{%user}}', 'passport_id', '{{%user_passport}}', 'id','CASCADE');
        $this->addForeignKey('{{%fk-user-passport_int_id}}', '{{%user}}', 'passport_int_id', '{{%user_int_passport}}', 'id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-user-passport_id}}', '{{%user}}');
        $this->dropForeignKey('{{%fk-user-passport_int_id}}', '{{%user}}');

        $this->dropIndex('{{%idx-user-passport_id}}', '{{%user}}');
        $this->dropIndex('{{%idx-user-passport_int_id}}', '{{%user}}');

        $this->dropColumn('{{%user}}','passport_id');
        $this->dropColumn('{{%user}}','passport_int_id');
        $this->dropColumn('{{%user}}','passport_rel_ids');
        $this->dropColumn('{{%user}}','phone');

        $this->alterColumn('{{%user}}','username',$this->string());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181116_121540_modify_user_table cannot be reverted.\n";

        return false;
    }
    */
}
