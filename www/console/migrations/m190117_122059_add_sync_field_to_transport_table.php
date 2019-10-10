<?php

use yii\db\Migration;

/**
 * Class m190117_122059_add_sync_field_to_transport_table
 */
class m190117_122059_add_sync_field_to_transport_table extends Migration {

    public function safeUp() {
        $this->addColumn('transport', 'sync', $this->boolean()->after('name')->defaultValue(TRUE));
    }

    public function safeDown() {
        $this->dropColumn('transport', 'sync');
    }

}
