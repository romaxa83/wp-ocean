<?php

use yii\db\Migration;

/**
 * Handles adding data_to_alpha_code to table `{{%country}}`.
 */
class m190504_121453_add_data_to_alpha_code_column_to_country_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $countries = array(
            8 => 'AUT',
            6 => 'AZE',
            10 => 'ALB',
            3 => 'AND',
            13 => 'BGR',
            27 => 'GBR',
            26 => 'HUN',
            29 => 'VNM',
            34 => 'GRC',
            33 => 'GEO',
            42 => 'DOM',
            43 => 'EGY',
            52 => 'ISR',
            46 => 'IND',
            47 => 'IDN',
            53 => 'JOR',
            49 => 'ESP',
            48 => 'ITA',
            166 => 'QAT',
            54 => 'CYP',
            58 => 'CHN',
            56 => 'CUB',
            67 => 'LVA',
            84 => 'MUS',
            78 => 'MYS',
            79 => 'MDV',
            73 => 'MLT',
            75 => 'MAR',
            80 => 'MEX',
            92 => 'ARE',
            93 => 'OMN',
            98 => 'POL',
            99 => 'PRT',
            104 => 'SYC',
            106 => 'SGP',
            108 => 'SVK',
            109 => 'SVN',
            111 => 'USA',
            113 => 'THA',
            152 => 'TZA',
            114 => 'TUN',
            115 => 'TUR',
            116 => 'UKR',
            120 => 'PHL',
            119 => 'FRA',
            134 => 'HRV',
            135 => 'MNE',
            122 => 'CZE',
            125 => 'LKA',
            128 => 'EST',
            132 => 'JAM');

        foreach ($countries as $key => $value) {
            Yii::$app->db->createCommand()->update(
                'country',
                ['alpha_3_code' => $value],
                "cid = {$key}")->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return TRUE;
    }
}
