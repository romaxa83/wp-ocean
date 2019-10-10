<?php

use yii\db\Migration;

/**
 * Class m181112_083241_add_field_settings_to_user
 */
class m181112_083241_add_field_settings_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','settings',$this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user','settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181112_083241_add_field_settings_to_user cannot be reverted.\n";

        return false;
    }
    */
}
