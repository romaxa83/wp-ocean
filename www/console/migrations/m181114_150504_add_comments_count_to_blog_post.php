<?php

use yii\db\Migration;

/**
 * Class m181114_150504_add_comments_count_to_blog_post
 */
class m181114_150504_add_comments_count_to_blog_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_posts}}', 'comments', $this->integer()->notNull()->defaultValue(0)->after('links'));

        $this->dropForeignKey('{{%fk-blog_post-country_id}}', '{{%blog_posts}}');
        $this->dropIndex('{{%idx-blog_posts-country_id}}', '{{%blog_posts}}');
        $this->dropColumn('{{%blog_posts}}', 'country_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_posts}}','comments');

        $this->addColumn('{{%blog_posts}}','country_id',$this->integer());
        $this->createIndex('{{%idx-blog_posts-country_id}}', '{{%blog_posts}}', 'country_id');
        $this->addForeignKey('{{%fk-blog_post-country_id}}', '{{%blog_posts}}', 'country_id', '{{%blog_categories}}', 'id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_150504_add_comments_count_to_blog_post cannot be reverted.\n";

        return false;
    }
    */
}
