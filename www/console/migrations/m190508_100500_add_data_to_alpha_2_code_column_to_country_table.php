<?php

use yii\db\Migration;

/**
 * Handles adding data_to_alpha_2_code to table `{{%country}}`.
 */
class m190508_100500_add_data_to_alpha_2_code_column_to_country_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $countries = array(
            8 => 'AT',
            6 => 'AZ',
            10 => 'AL',
            3 => 'AD',
            13 => 'BG',
            27 => 'GB',
            26 => 'HU',
            29 => 'VN',
            34 => 'GR',
            33 => 'GE',
            42 => 'DO',
            43 => 'EG',
            52 => 'IL',
            46 => 'IN',
            47 => 'ID',
            53 => 'JO',
            49 => 'ES',
            48 => 'IT',
            166 => 'QA',
            54 => 'CY',
            58 => 'CN',
            56 => 'CU',
            67 => 'LV',
            84 => 'MU',
            78 => 'MY',
            79 => 'MV',
            73 => 'MT',
            75 => 'MA',
            80 => 'MX',
            92 => 'AE',
            93 => 'OM',
            98 => 'PL',
            99 => 'PT',
            104 => 'SC',
            106 => 'SG',
            108 => 'SK',
            109 => 'SI',
            111 => 'US',
            113 => 'TH',
            152 => 'TZ',
            114 => 'TN',
            115 => 'TR',
            116 => 'UA',
            120 => 'PH',
            119 => 'FR',
            134 => 'HR',
            135 => 'ME',
            122 => 'CZ',
            125 => 'LK',
            128 => 'EE',
            132 => 'JM');

        foreach ($countries as $key => $value) {
            Yii::$app->db->createCommand()->update(
                'country',
                ['alpha_2_code' => $value],
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
