<?php

use yii\db\Migration;

/**
 * Class m190403_095456_added_field_icon_to_faq_category
 */
class m190403_095456_added_field_icon_to_faq_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%faq_category}}', 'media_id', $this->integer()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%faq_category}}', 'media_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190403_095456_added_field_icon_to_faq_category cannot be reverted.\n";

        return false;
    }
    */
}
