<?php

use yii\db\Migration;

/**
 * Class m181221_090252_modify_user_table
 */
class m181221_090252_modify_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'media_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}','media_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181221_090252_modify_user_table cannot be reverted.\n";

        return false;
    }
    */
}
