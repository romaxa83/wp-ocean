<?php

use yii\db\Migration;

/**
 * Class m190410_132130_added_ga_key_field_to_order_table
 */
class m190410_132130_added_ga_key_field_to_order_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%order}}', 'ga_key', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%order}}', 'ga_key', $this->string());
    }

}
