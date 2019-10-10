<?php

use yii\db\Migration;

/**
 * Class m190311_091046_added_field_alias_to_dept_city
 */
class m190311_091046_added_field_alias_to_dept_city extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('dept_city', 'alias', $this->string()->after('cid'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('dept_city', 'alias');
    }

}
