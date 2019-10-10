<?php

use yii\db\Migration;

/**
 * Class m191001_080943_add_fields_in_country_table
 */
class m191001_080943_add_fields_in_country_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%country}}', 'nameVn', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%country}}', 'nameVn');
    }

}
