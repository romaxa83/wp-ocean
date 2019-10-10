<?php

use yii\db\Migration;

/**
 * Class m190515_124019_added_field_confirm_token_to_user
 */
class m190515_124019_added_field_confirm_token_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'confirm_token', $this->string()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'confirm_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_124019_added_field_confirm_token_to_user cannot be reverted.\n";

        return false;
    }
    */
}
