<?php

use yii\db\Migration;

/**
 * Handles the creation of table `offer`.
 */
class m181220_111107_create_offer_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('offer', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'oid' => $this->string(),
            'operator_id' => $this->integer(),
            'code' => $this->string(),
            'craft' => $this->string(),
            'line' => $this->string(),
            'port_from' => $this->string(),
            'port_to' => $this->string(),
            'begin' => $this->dateTime(),
            'end' => $this->dateTime(),
            'sync' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('offer');
    }

}
