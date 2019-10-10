<?php

use yii\db\Migration;

/**
 * Class m181114_075759_change_blog_categories_table
 */
class m181114_075759_change_blog_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%blog_categories}}', 'type');
        $this->addColumn('{{%blog_categories}}', 'lft', $this->integer()->notNull()->after('status'));
        $this->addColumn('{{%blog_categories}}', 'rgt', $this->integer()->notNull()->after('lft'));
        $this->addColumn('{{%blog_categories}}', 'depth', $this->integer()->notNull()->after('rgt'));

        $this->insert('{{%blog_categories}}', [
            'id' => 1,
            'title' => 'Все категории',
            'alias' => 'root',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $cat = \backend\modules\blog\entities\Category::findOne(1);
//        $cat->delete();

        $this->dropColumn('{{%blog_categories}}', 'lft');
        $this->dropColumn('{{%blog_categories}}', 'rgt');
        $this->dropColumn('{{%blog_categories}}', 'depth');
        $this->addColumn('{{%blog_categories}}', 'type', $this->integer(1)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181114_075759_change_blog_categories_table cannot be reverted.\n";

        return false;
    }
    */
}
