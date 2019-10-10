<?php

use yii\db\Migration;

/**
 * Class m190822_080031_add_fields_id_tour_table
 */
class m190822_080031_add_fields_id_tour_table extends Migration {

    public function safeUp() {
        $this->addColumn('{{%tour}}', 'exotic_page', $this->boolean());
        $this->addColumn('{{%tour}}', 'hot_page', $this->boolean());
        $this->addColumn('{{%tour}}', 'sale_page', $this->boolean());
    }

    public function safeDown() {
        $this->dropColumn('{{%tour}}', 'exotic_page');
        $this->dropColumn('{{%tour}}', 'hot_page');
        $this->dropColumn('{{%tour}}', 'sale_page');
    }

}
