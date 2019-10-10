<?php

use yii\db\Migration;

/**
 * Class m190211_153550_added_field_country_to_blog_categories
 */
class m190211_153550_added_field_country_to_blog_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%blog_posts}}', 'country_id', $this->integer()->after('category_id'));
        $this->addColumn('{{%blog_posts}}', 'is_main', $this->integer(1)->notNull()->defaultValue(0)->after('status'));
        $this->addColumn('{{%blog_posts}}', 'position', $this->integer(1)->notNull()->defaultValue(0)->after('comments'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%blog_posts}}', 'country_id');
        $this->dropColumn('{{%blog_posts}}', 'is_main');
        $this->dropColumn('{{%blog_posts}}', 'position');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190211_153550_added_field_country_to_blog_categories cannot be reverted.\n";

        return false;
    }
    */
}
