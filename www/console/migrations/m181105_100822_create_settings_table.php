<?php

use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 */
class m181105_100822_create_settings_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'body' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('settings');
    }

}
