<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tour`.
 */
class m181218_085626_create_tour_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('tour', [
            'id' => $this->primaryKey(),
            'media_id' => $this->integer(),
            'seo_id' => $this->integer(),
            'stock_id' => $this->integer(),
            'operator_id' => $this->integer(),
            'dept_city_id' => $this->integer(),
            'city_id' => $this->integer(),
            'hotel_id' => $this->integer(),
            'type_number_id' => $this->integer(),
            'category_number_id' => $this->integer(),
            'type_food_id' => $this->integer(),
            'type_transport_id' => $this->integer(),
            'departure_id' => $this->integer(),
            'arrival_id' => $this->integer(),
            'title' => $this->string(),
            'type_description' => $this->string(),
            'description' => $this->text(),
            'price' => $this->decimal(65, 13),
            'old_price' => $this->decimal(65, 13),
            'promo_price' => $this->decimal(65, 13),
            'sale' => $this->decimal(65, 13),
            'currency' => $this->string(),
            'length' => $this->integer(),
            'date_begin' => $this->dateTime(),
            'date_end' => $this->dateTime(),
            'date_end_sale' => $this->dateTime(),
            'date_departure' => $this->dateTime(),
            'date_arrival' => $this->dateTime(),
            'status' => $this->boolean(),
            'sync' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('tour');
    }

}
