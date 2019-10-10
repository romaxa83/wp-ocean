<?php

use yii\db\Migration;

/**
 * Handles the creation of table `review`.
 */
class m181119_135955_create_review_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('review', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'date' => $this->dateTime(),
            'theme' => $this->string(),
            'body' => $this->text(),
            'status' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('review');
    }

}
