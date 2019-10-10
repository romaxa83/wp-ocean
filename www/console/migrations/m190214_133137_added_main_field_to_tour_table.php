<?php

use yii\db\Migration;

/**
 * Class m190214_133137_added_main_field_to_tour_table
 */
class m190214_133137_added_main_field_to_tour_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('tour', 'main', $this->tinyInteger()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('tour', 'main');
    }

}
