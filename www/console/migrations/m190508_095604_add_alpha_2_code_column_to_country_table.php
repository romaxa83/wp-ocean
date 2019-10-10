<?php

use yii\db\Migration;

/**
 * Handles adding alpha_2_code to table `{{%country}}`.
 */
class m190508_095604_add_alpha_2_code_column_to_country_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%country}}', 'alpha_2_code', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%country}}', 'alpha_2_code');
    }
}
