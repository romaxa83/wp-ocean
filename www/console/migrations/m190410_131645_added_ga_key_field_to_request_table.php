<?php

use yii\db\Migration;

/**
 * Class m190410_131645_added_ga_key_field_to_request_table
 */
class m190410_131645_added_ga_key_field_to_request_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%request}}', 'ga_key', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%request}}', 'ga_key', $this->string());
    }

}
