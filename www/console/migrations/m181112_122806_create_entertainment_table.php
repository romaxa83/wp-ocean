<?php

use yii\db\Migration;

/**
 * Handles the creation of table `entertainment`.
 */
class m181112_122806_create_entertainment_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('entertainment', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(),
            'city_id' => $this->integer(),
            'media_id' => $this->integer(),
            'name' => $this->string(),
            'description' => $this->text(),
            'status' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('entertainment');
    }

}
