<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\City;

class Country extends ActiveRecord {

    public static function tableName() {
        return 'country';
    }

    public function rules() {
        return [
            [['media_id', 'code', 'name', 'alias', 'country_description', 'doc_description', 'visa_description', 'lat', 'lng', 'zoom', 'visa', 'status', 'alpha_3_code'], 'required'],
            ['code', 'string', 'length' => [0, 255]],
            ['name', 'string', 'length' => [0, 255]],
            ['alias', 'string', 'length' => [0, 255]],
            ['alias', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'message' => 'Поле может содержать только латинские буквенно-цифровые символы и подчеркивания.'],
            ['visa', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['alpha_2_code', 'string'],
            ['alpha_3_code', 'string'],
            ['region_id', 'integer'],
            ['alpha_2_code', 'match',
                'pattern' => '/^[A-Z]{2}$/',
                'message' => 'Поле может содержать только 2 латинские буквы в верхнем регистре и должно быть alpha-2 кодом страны.'
            ],
            ['alpha_3_code', 'match',
                'pattern' => '/^[A-Z]{3}$/',
                'message' => 'Поле может содержать только 3 латинские буквы в верхнем регистре и должно быть alpha-3 кодом страны.'
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cid' => 'ID Страны (API)',
            'media_id' => 'Баннер',
            'code' => 'Код',
            'name' => 'Название',
            'alias' => 'Алиас',
            'country_description' => 'Описание',
            'doc_description' => 'Необходимые документы',
            'visa_description' => 'Описание визы',
            'lat' => 'Широта',
            'lng' => 'Долгота',
            'zoom' => 'Увеличить',
            'visa' => 'Виза',
            'status' => 'Статус',
            'sync' => 'Синхронизация',
            'alpha_2_code' => 'Код alpha-2',
            'alpha_3_code' => 'Код alpha-3',
            'region_id' => 'Регион',
        ];
    }

    public function getCity() {
        return $this->hasMany(City::className(), ['country_id' => 'cid'])->orderBy(['position' => SORT_ASC]);
    }

    public function getRegion() {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

}
