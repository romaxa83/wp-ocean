<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_hotel_review}}`.
 */
class m190213_121853_create_blog_hotel_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_hotel_review}}', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'seo_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'alias' => $this->string()->notNull(),
            'description' => $this->string(),
            'content' => 'MEDIUMTEXT',
            'media_ids' => $this->string(),
            'views' => $this->integer()->defaultValue(0),
            'likes' => $this->integer()->defaultValue(0),
            'links' => $this->integer()->defaultValue(0),
            'status' => $this->integer(1),
            'published_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-blog_posts-alias}}', '{{%blog_hotel_review}}', 'alias');
        $this->createIndex('{{%idx-blog_posts-hotel_id}}', '{{%blog_hotel_review}}', 'hotel_id');

        $this->addForeignKey('{{%fk-blog_post-hotel_id}}', '{{%blog_hotel_review}}', 'hotel_id', '{{%hotel}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-blog_post-hotel_id}}', '{{%blog_hotel_review}}');
        $this->dropTable('{{%blog_hotel_review}}');
    }
}
