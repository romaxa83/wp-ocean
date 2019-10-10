<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hash`.
 */
class m181004_131140_create_hash_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('hash', [
            'id' => $this->primaryKey(),
            'api_id' => $this->integer(),
            'link' => $this->text(),
            'hash' => $this->string(),
            'cache' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('hash');
    }

}
