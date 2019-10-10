<?php

use yii\db\Migration;
use backend\models\Settings;
use yii\helpers\Json;

/**
 * Class m190413_094739_add_data_in_settings_table
 */
class m190413_094739_add_data_in_settings_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $settings = Settings::find()->where(['name' => 'contact'])->one();
        $body = Json::decode($settings->body);
        $body[] = [
            'key' => 'phone_header',
            'name' => 'Телефон (header)',
            'value' => '+38 (095) 277 10 33'
        ];
        $body[] = [
            'key' => 'phone_footer',
            'name' => 'Телефон (footer)',
            'value' => '+38 (095) 277 10 33'
        ];
        $settings->body = Json::encode($body);
        $settings->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return TRUE;
    }
    

}
