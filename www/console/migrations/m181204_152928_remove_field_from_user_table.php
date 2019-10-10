<?php

use yii\db\Migration;

/**
 * Class m181204_152928_remove_field_from_user_table
 */
class m181204_152928_remove_field_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user}}', 'passport_rel_ids');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user}}', 'passport_rel_ids', $this->text()->after('passport_int_id'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_152928_remove_field_from_user_table cannot be reverted.\n";

        return false;
    }
    */
}
