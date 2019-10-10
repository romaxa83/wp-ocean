<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hotel_review`.
 */
class m190123_144505_create_hotel_review_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('hotel_review', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'rid' => $this->integer(),
            'date' => $this->dateTime(),
            'user' => $this->string(),
            'avatar' => $this->string(),
            'title' => $this->string(),
            'comment' => $this->text(),
            'vote' => $this->smallInteger(),
            'status' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('hotel_review');
    }

}
