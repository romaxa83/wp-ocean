<?php

use yii\db\Migration;

/**
 * Handles the creation of table `api`.
 */
class m181004_113940_create_api_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('api', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'href' => $this->string(),
            'token' => $this->string(),
        ]);
        
        $api = new \backend\models\Api();
        $api->name = 'Отпуск';
        $api->href = 'https://export.otpusk.com';
        $api->token = '273be-019f1-02bb0-c2607-3e982';
        $api->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('api');
    }

}
