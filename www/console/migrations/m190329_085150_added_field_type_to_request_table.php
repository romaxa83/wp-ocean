<?php

use yii\db\Migration;

/**
 * Class m190329_085150_added_field_type_to_request_table
 */
class m190329_085150_added_field_type_to_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%request}}', 'type', $this->integer(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%request}}', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190329_085150_added_field_type_to_request_table cannot be reverted.\n";

        return false;
    }
    */
}
