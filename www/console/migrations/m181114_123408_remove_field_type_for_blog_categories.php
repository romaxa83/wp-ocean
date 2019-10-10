<?php

use yii\db\Migration;

/**
 * Class m181114_123408_remove_field_type_for_blog_categories
 */
class m181114_123408_remove_field_type_for_blog_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%blog_categories}}', 'position');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%blog_categories}}', 'position', $this->integer()->defaultValue(0));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_123408_remove_field_type_for_blog_categories cannot be reverted.\n";

        return false;
    }
    */
}
