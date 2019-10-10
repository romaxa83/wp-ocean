<?php

use yii\db\Migration;

/**
 * Class m181109_083731_change_blog_posts_table
 */
class m181109_083731_change_blog_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%blog_posts}}','image');
        $this->addColumn('{{%blog_posts}}','media_id',$this->integer()->after('content'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_posts}}','media_id');
        $this->addColumn('{{%blog_posts}}','image',$this->string()->after('content'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181109_083731_change_blog_posts_table cannot be reverted.\n";

        return false;
    }
    */
}
