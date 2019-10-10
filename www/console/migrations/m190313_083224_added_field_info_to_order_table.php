<?php

use yii\db\Migration;

/**
 * Class m190313_083224_added_field_info_to_order_table
 */
class m190313_083224_added_field_info_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'info', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order','info');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190313_083224_added_field_info_to_order_table cannot be reverted.\n";

        return false;
    }
    */
}
