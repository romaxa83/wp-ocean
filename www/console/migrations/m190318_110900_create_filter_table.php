<?php

use yii\db\Migration;
use backend\modules\filter\models\Filter;
/**
 * Handles the creation of table `{{%filter}}`.
 */
class m190318_110900_create_filter_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%filter}}', [
            'id' => $this->primaryKey(),
            'alias' => $this->string(),
            'link' => $this->string(),
            'name' => $this->string(),
            'country' => $this->text(),
            'dept_city' => $this->text(),
            'date' => $this->text(),
            'length' => $this->text(),
            'people' => $this->text(),
            'category' => $this->text(),
            'food' => $this->text(),
            'price' => $this->text(),
            'city' => $this->text(),
            'hotel' => $this->text(),
            'status' => $this->boolean()
        ]);
        $filter = new Filter();
        $filter->alias = 'default';
        $filter->link = 'turkey-kiev';
        $filter->name = 'Фильтр по умолчанию';
        $filter->country = 'a:3:{s:8:"priority";s:1:"2";s:7:"country";a:52:{i:0;i:42;i:1;i:12;i:2;i:1;i:3;i:2;i:4;i:3;i:5;i:4;i:6;i:5;i:7;i:6;i:8;i:7;i:9;i:8;i:10;i:9;i:11;i:10;i:12;i:11;i:13;i:13;i:14;i:14;i:15;i:15;i:16;i:16;i:17;i:17;i:18;i:18;i:19;i:19;i:20;i:20;i:21;i:21;i:22;i:22;i:23;i:23;i:24;i:24;i:25;i:25;i:26;i:26;i:27;i:27;i:28;i:28;i:29;i:29;i:30;i:30;i:31;i:31;i:32;i:32;i:33;i:33;i:34;i:34;i:35;i:35;i:36;i:36;i:37;i:37;i:38;i:38;i:39;i:39;i:40;i:40;i:41;i:41;i:42;i:43;i:43;i:44;i:44;i:45;i:45;i:46;i:46;i:47;i:47;i:48;i:48;i:49;i:49;i:50;i:50;i:51;i:51;i:52;}s:7:"default";s:2:"42";}';
        $filter->dept_city = 'a:2:{s:9:"dept_city";a:30:{i:0;i:8;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;i:7;i:8;i:9;i:9;i:10;i:10;i:11;i:11;i:12;i:12;i:13;i:13;i:14;i:14;i:15;i:15;i:16;i:16;i:17;i:17;i:18;i:18;i:19;i:19;i:20;i:20;i:21;i:21;i:22;i:22;i:23;i:23;i:24;i:24;i:25;i:25;i:26;i:26;i:27;i:27;i:28;i:28;i:29;i:29;i:30;}s:7:"default";s:1:"8";}';
        $filter->date = 'a:1:{s:7:"default";s:2:"14";}';
        $filter->length = 'a:2:{s:6:"length";a:25:{i:0;i:2;i:1;i:3;i:2;i:4;i:3;i:5;i:4;i:6;i:5;i:7;i:6;i:8;i:7;i:9;i:8;i:10;i:9;i:11;i:10;i:12;i:11;i:13;i:12;i:14;i:13;i:15;i:14;i:16;i:15;i:17;i:16;i:18;i:17;i:19;i:18;i:20;i:19;i:21;i:20;i:22;i:21;i:23;i:22;i:24;i:23;i:25;i:24;i:26;}s:7:"default";s:1:"7";}';
        $filter->people = 'a:1:{s:7:"default";s:1:"2";}';
        $filter->category = 'a:1:{s:8:"category";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}';
        $filter->food = 'a:1:{s:4:"food";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}';
        $filter->price = 'a:3:{s:4:"from";s:1:"0";s:2:"to";s:6:"100000";s:8:"currency";s:3:"UAH";}';
        $filter->city = '{"43":[323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342],"115":[1085,1086,1087,1088,1089,1090,1091,1092,1093,1094,1095,1096,1097,1098,1099,1100,1101,1102,1103,1104,1105,1106,1107,1108,1109,1110,1111,1112,1113,1114,1115,1116,1117,1118,1119,1120,1121,1122,1123,1124,1125,1126,1127,1128,1129,1130,1131,1132,1133,1134]}';
        $filter->hotel = '{"43":{"715":[2804,2806,2814,2817,2819,2823,2824,2825,2827,2828,2831,2841,2842,2844,2845,2846,2847,2851,2852,2853,2856,2858,2859,2861,2862,2863,2864,2866,2867,2868,2871,2873,2874,2875,2876,2877,2878,2879,2880,2883,2885,2887,2896,2897,2899,2900,2903,2904,2905,2906,2916,2918,2925,2928,2929,2930,2932,2934,2935,2937,2938,2942,2947,2955,2956,2957,2962,2971,2973,2977,2978,2982,2987,2988,2989,2991,2992,2996,2999,3004,3007,3009,3010,3012,3013,3015,3016,3017,3018,3019,3021,3024,3025,3026,3035,3036,3039,3040,3041,3043,3044,3045,3046,3047,3048,3050,3052,3053,3055,3056,3057,3062,3063,3071,3076,3077,3078,3079,3080,3081,3082,3083,3084,3085,3086,3088,3089,3091,3096,3097,3101,3107,3112,3116,3117,3119,3125,3131,3133,3135,3153,3156,3158,3160,3162,3163,3165,3166,3167,3168,3173,3174,3175]},"115":{"953":[7518,7545,7546,7547,7548,7549,7550,7551,7552,7560,7583,7587,7594,7595,7596,7597,7598,7603,7605,7612,7624,7633,7637,7638,7639,7641,7643,7645,7647,7648,7654,7659,7663,7669,7670,7676,7678,7683,7685,7690,7693,7697,7705,7716,7728,7738,7746,7747,7750,7752,7753,7756,7766,7768,7770,7773,7777,7786,7796,7800,7801,7803,7827,7833,7835,7837,7839,7842,7844,7850,7857,7862,7867,7873,7877,7879,7880,7882,7883,7885,7891,7925,7930,7934,7935,7948,7951,7956,7960,7961,7964,7968,7985,7989,7990,7991,7992,7993,7994,8002,8008,8009,8010,8013,8017,8027,8056,8061,8067,8070,8071,8072,8076,8077,8089,8090,8091,8108,8111,8112,8122,8131,8145,8146,8153,8154,8158,8159,8163,8164,8169,8171,8178,8181,8183,8184,8185,8186,8194,8197,8198,8199,8229,8230,8234,8240,8243,8260,8261,8262,8265,8266,8272,8279,8287,8288,8306,8307,8310,8311,8312,8313,8314,8315,8316,8317,8318,8319,8320,8321,8322,8323,8324,8325,8326,8327,8328,8329,8330,8331,8332,8333,8334,8335,8336,8338,8340,8348,8358,8367,8370,8376,8389,8390,8416,8421,8423,8424,8425,8426,8427,8434,8438,8439,8440,8442,8455,8456,8480,8484,8497,8503,8504,8509,8513,8514,8516,8518,8524,8530,8538,8544,8545,8549,8553,8555,8558,8559,8562,8563,8584,8593,8594,8595,8596,8597,8607,8613,8614,8625,8627,8632,8634,8645,8662,8666,8667,8669,8687,8720,8721,8723,8737,8745,8765,8772,8774,8779,8780,8791,8795,8796,8797,8803,8811,8828,8835,8840,8841,8842,8851,8889,8896,8901,8917,8929,8942,8945,8946,8947,8960,8965,8966,8967,8981,8983,8984,8989,8992,9008,9013,9032,9033,9034,9041,9051,9052,9053,9089,9091,9103,9104,9106,9108,9109,9119,9122,9124,9125,9126,9135,9136,9137,9138,9139,9140,9141,9142,9148,9160]}}';
        $filter->status = TRUE;
        $filter->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%filter}}');
    }

}
