<?php

namespace backend\modules\referenceBooks\models;

use backend\modules\filemanager\models\Mediafile;
use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\specials\models\Special;
use backend\modules\referenceBooks\models\Operator;

class Tour extends ActiveRecord {

    CONST SCENARIO_USER_SAVE = 'user_save';

    public static function tableName() {
        return 'tour';
    }

    public function rules() {
        return [
            [['media_id', 'seo_id', 'dept_city_id', 'city_id', 'hotel_id', 'type_number_id', 'category_number_id',
            'type_food_id', 'type_transport_id', 'arrival_id', 'departure_id', 'arrival_id', 'arrival_id', 'title', 'type_description', 'description', 'price',
            'old_price', 'promo_price', 'currency', 'length', 'date_begin', 'date_end', 'date_end_sale', 'date_departure', 'date_arrival',
            'status', 'sync'], 'required'],
            [['media_id', 'seo_id', 'stock_id', 'operator_id', 'dept_city_id', 'city_id', 'hotel_id', 'type_number_id', 'category_number_id', 'type_food_id',
            'type_transport_id', 'departure_id', 'arrival_id', 'length'], 'number'],
            [['title', 'currency'], 'string', 'length' => [0, 255]],
            [['status', 'sync'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['date_end', 'compare', 'compareAttribute' => 'date_begin', 'operator' => '>', 'on' => 'user_save'],
            ['date_begin', 'compare', 'compareAttribute' => 'date_end', 'operator' => '<', 'on' => 'user_save'],
            ['date_departure', 'compare', 'compareAttribute' => 'date_end', 'operator' => '>=', 'on' => 'user_save'],
            ['date_arrival', 'compare', 'compareAttribute' => 'date_departure', 'operator' => '>=', 'on' => 'user_save'],
            ['date_end_sale', 'compare', 'compareAttribute' => 'date_end', 'operator' => '<=', 'on' => 'user_save'],
            ['date_end_sale', 'compare', 'compareAttribute' => 'date_departure', 'operator' => '<=', 'on' => 'user_save'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'media_id' => 'Изображение',
            'seo_id' => 'ID SEO',
            'stock_id' => 'Акция',
            'operator_id' => 'Оператор',
            'dept_city_id' => 'Город отправления',
            'city_id' => 'Город прибытия',
            'hotel_id' => 'Отель',
            'type_number_id' => 'Тип номера',
            'category_number_id' => 'Категория номера',
            'type_food_id' => 'Питание',
            'type_transport_id' => 'Тип транспорта',
            'departure_id' => 'Отправление из',
            'arrival_id' => 'Прибытие в',
            'title' => 'Заголовок',
            'type_description' => 'Тип описания',
            'description' => 'Описание',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'promo_price' => 'Промо цена',
            'sale' => 'Скидка (%)',
            'currency' => 'Валюта',
            'length' => 'Кол-во ночей',
            'date_begin' => 'Период активности от',
            'date_end' => 'Период активности до',
            'date_end_sale' => 'Дата окончания продаж',
            'date_departure' => 'Дата отправления',
            'date_arrival' => 'Дата прибытия',
            'main' => 'Топ продаж',
            'recommend' => '5 океан рекомендует',
            'hot' => 'Горящие туры',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

    //Relations
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['hid' => 'hotel_id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getDeptCity()
    {
        return $this->hasOne(DeptCity::className(), ['cid' => 'dept_city_id']);
    }

    public function getFood()
    {
        return $this->hasOne(TypeFood::className(), ['id' => 'type_food_id']);
    }

    public function getTransport()
    {
        return $this->hasOne(Transport::className(), ['id' => 'type_transport_id']);
    }

    public function getMedia()
    {
        return $this->hasOne(Mediafile::className(), ['id' => 'media_id']);
    }

    public function getSpecial()
    {
        return $this->hasOne(Special::className(), ['id' => 'stock_id']);
    }

    public function getOperator()
    {
        return $this->hasOne(Operator::className(), ['id' => 'operator_id']);
    }

    public static function uncheckPosition($data) {
        if ($data['main'] != 0) {
            Tour::updateAll(['main' => 0], ['main' => $data['main']]);
        }
        if ($data['recommend'] != 0) {
            Tour::updateAll(['recommend' => 0], ['recommend' => $data['recommend']]);
        }
        if ($data['hot'] != 0) {
            Tour::updateAll(['hot' => 0], ['hot' => $data['hot']]);
        }
    }
}
