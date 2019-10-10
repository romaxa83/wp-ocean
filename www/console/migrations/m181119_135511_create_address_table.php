<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m181119_135511_create_address_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'hotel_id' => $this->integer(),
            'hid' => $this->integer(),
            'address' => $this->text(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'site' => $this->string(),
            'data_source' => $this->string(),
            'lat' => $this->decimal(65, 5),
            'lng' => $this->decimal(65, 5),
            'zoom' => $this->integer(),
            'location' => $this->tinyInteger(),
            'general_description' => $this->text(),
            'location_description' => $this->text(),
            'food_description' => $this->text(),
            'distance_sea' => $this->string(),
            'beach_type' => $this->tinyInteger(),
            'beach_description' => $this->text(),
            'location_animals' => $this->smallInteger(),
            'additional_information' => $this->text(),
            'sync' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('address');
    }

}
