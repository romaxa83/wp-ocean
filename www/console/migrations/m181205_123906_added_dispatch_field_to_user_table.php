<?php

use yii\db\Migration;

/**
 * Class m181205_123906_added_dispatch_field_to_user_table
 */
class m181205_123906_added_dispatch_field_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'dispatch', $this->boolean()->notNull()->defaultValue(false)->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}','dispatch');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181205_123906_added_dispatch_field_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
