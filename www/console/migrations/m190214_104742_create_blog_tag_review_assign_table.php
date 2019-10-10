<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tag_review_assign}}`.
 */
class m190214_104742_create_blog_tag_review_assign_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%blog_tag_review_assign}}', [
            'hotel_review_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-blog_tag_review_assign}}', '{{%blog_tag_review_assign}}', ['hotel_review_id', 'tag_id']);

        $this->createIndex('{{%idx-blog_tag_review_assign-hotel_review_id}}', '{{%blog_tag_review_assign}}', 'hotel_review_id');
        $this->createIndex('{{%idx-blog_tag_review_assign-tag_id}}', '{{%blog_tag_review_assign}}', 'tag_id');

        $this->addForeignKey('{{%fk-blog_tag_review_assign-hotel_review_id}}', '{{%blog_tag_review_assign}}', 'hotel_review_id', '{{%blog_hotel_review}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-blog_tag_review_assign-tag_id}}', '{{%blog_tag_review_assign}}', 'tag_id', '{{%blog_tags}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropForeignKey('{{%fk-blog_tag_review_assign-hotel_review_id}}', '{{%blog_tag_review_assign}}');
//        $this->dropForeignKey('{{%fk-blog_tag_review_assign-tag_id}}', '{{%blog_tag_review_assign}}');

        $this->dropTable('{{%blog_tag_review_assign}}');
    }
}
