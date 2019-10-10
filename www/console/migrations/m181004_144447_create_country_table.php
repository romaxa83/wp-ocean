<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country`.
 */
class m181004_144447_create_country_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('country', [
            'id' => $this->primaryKey(),
            'media_id' => $this->integer(),
            'cid' => $this->integer(),
            'code' => $this->string(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'country_description' => $this->text(),
            'doc_description' => $this->text(),
            'visa_description' => $this->text(),
            'lat' => $this->decimal(65, 13),
            'lng' => $this->decimal(65, 13),
            'zoom' => $this->smallInteger(),
            'visa' => $this->boolean(),
            'status' => $this->boolean()->defaultValue(TRUE),
            'sync' => $this->boolean()->defaultValue(TRUE),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('country');
    }

}
