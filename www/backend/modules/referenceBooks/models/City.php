<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Country;

class City extends ActiveRecord {

    public static function tableName() {
        return 'city';
    }

    public function rules() {
        return [
            [['country_id', 'code', 'name', 'alias', 'description', 'lat', 'lng', 'zoom', 'status', 'capital', 'sync'], 'required'],
            ['code', 'string', 'length' => [0, 255]],
            ['name', 'string', 'length' => [0, 255]],
            ['alias', 'string', 'length' => [0, 255]],
            ['alias', 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => 'Поле может содержать только латинские буквенно-цифровые символы и подчеркивания.'],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['sync', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'country_id' => 'Cтрана',
            'cid' => 'ID Города (API)',
            'code' => 'Код',
            'name' => 'Название',
            'description' => 'Описание',
            'lat' => 'Широта',
            'lng' => 'Долгота',
            'zoom' => 'Увеличить',
            'status' => 'Статус',
            'capital' => 'Cтолица',
            'sync' => 'Синхронизация'
        ];
    }

    public function getCountry() {
        return $this->hasOne(Country::className(), ['cid' => 'country_id']);
    }

}
