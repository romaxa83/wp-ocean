<?php

use yii\db\Migration;

/**
 * Class m190503_132035_add_menu_item_for_faq
 */
class m190503_132035_add_menu_item_for_faq extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('menu_item',[
            'menu_id','parent_id','type','title','data','position','status'
        ],[
            [1,2,'route','F.A.Q','{"route":"/faq/category/slug"}',4,1],
            [2,18,'route','F.A.Q','{"route":"/faq/category/slug"}',3,1]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \backend\modules\menuBuilder\models\MenuItem::deleteAll(['title' => 'F.A.Q']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190503_132035_add_menu_item_for_faq cannot be reverted.\n";

        return false;
    }
    */
}
