<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rating`.
 */
class m181119_135338_create_rating_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('rating', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'rid' => $this->string(),
            'name' => $this->string(),
            'vote' => $this->decimal(65, 13),
            'count' => $this->integer(),
            'status' => $this->boolean(),
            'sync' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('rating');
    }

}
