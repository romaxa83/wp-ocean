<?php

use yii\db\Migration;
use backend\models\Settings;
use yii\helpers\Json;

/**
 * Class m190304_123403_add_data_in_settings_table
 */
class m190304_123403_add_data_in_settings_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $settings = Settings::find()->where(['name' => 'contact'])->one();
        $body = Json::decode($settings->body);
        $body[] = [
            'key' => 'latitude',
            'name' => 'Широта',
            'value' => 0
        ];
        $body[] = [
            'key' => 'longitude',
            'name' => 'Долгота',
            'value' => 0
        ];
        $settings->body = Json::encode($body);
        $settings->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        
    }

}
