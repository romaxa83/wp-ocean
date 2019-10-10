<?php

use yii\db\Migration;

/**
 * Class m191001_081547_add_fields_in_city_table
 */
class m191001_081547_add_fields_in_city_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%city}}', 'nameVn', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%city}}', 'nameVn');
    }

}
