<?php

use yii\db\Migration;

/**
 * Class m190521_110547_added_field_rel_to_dept_city
 */
class m190521_110547_added_field_rel_to_dept_city extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%dept_city}}', 'rel', $this->string()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%dept_city}}', 'rel');
    }

}
