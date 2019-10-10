<?php

use yii\db\Migration;

/**
 * Class m190218_100415_added_field_user_id_to_hotel_review
 */
class m190218_100415_added_field_user_id_to_hotel_review extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%hotel_review}}','user_id',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%hotel_review}}','user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190218_100415_added_field_user_id_to_hotel_review cannot be reverted.\n";

        return false;
    }
    */
}
