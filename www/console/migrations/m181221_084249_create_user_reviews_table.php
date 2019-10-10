<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_reviews`.
 */
class m181221_084249_create_user_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_reviews}}', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'text' => $this->text(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'rating' => $this->integer(1)->notNull()->defaultValue(0),
            'from_date' => $this->integer(),
            'to_date' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-user-reviews_hotel-id}}', '{{%user_reviews}}', 'hotel_id');
        $this->createIndex('{{%idx-user-reviews_user-id}}', '{{%user_reviews}}', 'user_id');

        $this->addForeignKey('{{%fk-user-reviews_hotel_id}}', '{{%user_reviews}}', 'hotel_id', '{{%hotel}}', 'id','CASCADE');
        $this->addForeignKey('{{%fk-user-reviews_user_id}}', '{{%user_reviews}}', 'user_id', '{{%user}}', 'id','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-user-reviews_hotel_id}}', '{{%user_reviews}}');
        $this->dropForeignKey('{{%fk-user-reviews_user_id}}', '{{%user_reviews}}');

        $this->dropTable('{{%user_reviews}}');
    }
}
