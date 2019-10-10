<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class Address extends ActiveRecord {

    public static function tableName() {
        return 'address';
    }

    public function rules() {
        return [
            [['hotel_id', 'address', 'phone', 'email', 'lat', 'lng', 'zoom'], 'required'],
            [['hotel_id', 'zoom'], 'integer'],
            [['lat', 'lng'], 'double'],
            [['address', 'phone', 'email'], 'string', 'length' => [0, 255]],
            [['sync'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hotel_id' => 'Отель',
            'address' => 'Адрес',
            'phone' => 'Телефоны',
            'email' => 'Email',
            'site' => 'Сайт',
            'data_source' => 'Источник данных',
            'lat' => 'Широта',
            'lng' => 'Долгота',
            'zoom' => 'Увеличить',
            'location' => 'Положение от центра города',
            'general_description' => 'Общее описания',
            'location_description' => 'Описание расположения',
            'food_description' => 'Описания питания',
            'distance_sea' => 'Расстояние до моря (м)',
            'beach_type' => 'Тип пляжа',
            'beach_description' => 'Описание пляжа',
            'location_animals' => 'Размещение с животными',
            'additional_information' => 'Дополнительная информация'
        ];
    }

}
