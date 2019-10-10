<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog_posts`.
 */
class m181106_092457_create_blog_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_posts}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'country_id' => $this->integer(),
            'author_id' => $this->integer(),
            'seo_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'alias' => $this->string()->notNull(),
            'description' => $this->string(),
            'content' => 'MEDIUMTEXT',
            'image' => $this->string(),
            'views' => $this->integer()->defaultValue(0),
            'likes' => $this->integer()->defaultValue(0),
            'links' => $this->integer()->defaultValue(0),
            'status' => $this->integer(1),
            'published_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-blog_posts-alias}}', '{{%blog_posts}}', 'alias');
        $this->createIndex('{{%idx-blog_posts-category_id}}', '{{%blog_posts}}', 'category_id');
        $this->createIndex('{{%idx-blog_posts-country_id}}', '{{%blog_posts}}', 'country_id');
        $this->createIndex('{{%idx-blog_posts-author_id}}', '{{%blog_posts}}', 'author_id');

        $this->addForeignKey('{{%fk-blog_post-category_id}}', '{{%blog_posts}}', 'category_id', '{{%blog_categories}}', 'id');
        $this->addForeignKey('{{%fk-blog_post-country_id}}', '{{%blog_posts}}', 'country_id', '{{%blog_categories}}', 'id');
        $this->addForeignKey('{{%fk-blog_post-author_id}}', '{{%blog_posts}}', 'author_id', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-blog_post-category_id}}', '{{%blog_posts}}');
        $this->dropForeignKey('{{%fk-blog_post-country_id}}', '{{%blog_posts}}');
        $this->dropForeignKey('{{%fk-blog_post-author_id}}', '{{%blog_posts}}');

        $this->dropTable('{{%blog_posts}}');
    }
}
