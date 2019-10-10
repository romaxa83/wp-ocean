<?php

use yii\db\Migration;
use backend\models\Settings;

/**
 * Class m190625_133929_add_data_in_settings_table
 */
class m190625_133929_add_data_in_settings_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $settings = new Settings();
        $settings->name = 'promo_price';
        $settings->body = 0;
        $settings->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        Settings::deleteAll(['name' => 'promo_price']);
    }

}
