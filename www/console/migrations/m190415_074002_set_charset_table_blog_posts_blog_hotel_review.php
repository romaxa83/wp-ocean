<?php

use yii\db\Migration;

/**
 * Class m190415_074002_set_charset_table_blog_posts_blog_hotel_review
 */
class m190415_074002_set_charset_table_blog_posts_blog_hotel_review extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        Yii::$app->db->createCommand()->execute('ALTER TABLE `blog_posts` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
        Yii::$app->db->createCommand()->execute('ALTER TABLE `blog_hotel_review` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return TRUE;
    }

}
