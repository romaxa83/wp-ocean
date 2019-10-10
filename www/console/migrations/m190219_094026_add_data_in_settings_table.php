<?php

use yii\db\Migration;
use backend\modules\settings\Settings;

/**
 * Class m190219_094026_add_data_in_settings_table
 */
class m190219_094026_add_data_in_settings_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        Yii::$app->db->createCommand()->insert('settings', ['name' => 'contact', 'body' => '[{"key":"address","name":"Адрес","value":"г. Херсон, ул. 9-го января, 29"},{"key":"phone","name":"Телефон","value":"+38 (050) 50 34 656 / (0552) 422 562 / (0552) 422 282"},{"key":"email","name":"E-mail","value":"office@tourism.ks.ua"},{"key":"work","name":"Режим работы","value":"пн-пт: 09:30 - 18:00 / сб: 10:00 - 15:00"}]'])->execute();
        Yii::$app->db->createCommand()->insert('settings', ['name' => 'social', 'body' => '[{"key":"facebook","name":"FaceBook","value":"https://www.facebook.com/5okean/"},{"key":"instagram","name":"Instagram","value":"https://www.instagram.com/5_okean/"},{"key":"youtube","name":"YouTube","value":"https://www.youtube.com/channel/UCYMl_xKoHYbbZdovl06Clpw"},{"key":"telegram","name":"Telegram","value":"https://t.me/ta5okean"}]'])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        Yii::$app->db->createCommand()->delete('settings', ['in', 'name', ['contact', 'social']])->execute();
    }

}
