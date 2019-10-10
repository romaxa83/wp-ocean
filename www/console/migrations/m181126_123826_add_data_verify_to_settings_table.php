<?php

use backend\models\Settings;
use yii\db\Migration;

/**
 * Class m181126_123826_add_data_verify_to_settings_table
 */
class m181126_123826_add_data_verify_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new Settings();
        $model->name = 'verify_passport';
        $model->body = '0';
        $model->save();

        $model_1 = new Settings();
        $model_1->name = 'verify_int_passport';
        $model_1->body = '0';
        $model_1->save();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        (Settings::find()->where(['name' => 'verify_passport'])->one())->delete();
        (Settings::find()->where(['name' => 'verify_int_passport'])->one())->delete();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181126_123826_add_data_verify_to_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
