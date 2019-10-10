<?php

use yii\db\Migration;

/**
 * Class m190401_095406_added_created_field_to_user_smart_mailing
 */
class m190401_095406_added_created_field_to_user_smart_mailing extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_smart_mailing}}', 'created', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_smart_mailing}}', 'created');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190401_095406_added_created_field_to_user_smart_mailing cannot be reverted.\n";

        return false;
    }
    */
}
