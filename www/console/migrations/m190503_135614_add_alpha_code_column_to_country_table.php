<?php

use yii\db\Migration;

/**
 * Handles adding alpha_code to table `{{%country}}`.
 */
class m190503_135614_add_alpha_code_column_to_country_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%country}}', 'alpha_3_code', $this->string());
        $this->addColumn('{{%country}}', 'region_id', $this->integer());

        // creates index for column `region_id`
        $this->createIndex(
            'idx-country-region_id',
            'country',
            'region_id'
        );

        // add foreign key for table `region`
        $this->addForeignKey(
            'fk-country-region_id',
            'country',
            'region_id',
            'region',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for table `region`
        $this->dropForeignKey(
            'fk-country-region_id',
            'country'
        );

        // drops index for column `region_id`
        $this->dropIndex(
            'idx-country-region_id',
            'country'
        );

        $this->dropColumn('{{%country}}', 'alpha_3_code');
        $this->dropColumn('{{%country}}', 'region_id');
    }
}
