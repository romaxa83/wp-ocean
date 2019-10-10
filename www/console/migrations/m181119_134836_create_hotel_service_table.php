<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hotel_service`.
 */
class m181119_134836_create_hotel_service_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('hotel_service', [
            'hotel_id' => $this->integer(),
            'hid' => $this->integer(),
            'service_id' => $this->integer(),
            'type' => $this->string(),
            'price' => $this->decimal(65, 13),
            'sync' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('hotel_service');
    }

}
