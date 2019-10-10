<?php

use yii\db\Migration;

/**
 * Class m190503_063620_add_data_to_region_table
 */
class m190503_063620_add_data_to_region_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $regions = ['Africa', 'South America', 'North America', 'Asia', 'Europe', 'Oceania'];
        foreach ($regions as $region) {
            $this->insert('region', [
                'name' => $region,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return TRUE;
    }
}
