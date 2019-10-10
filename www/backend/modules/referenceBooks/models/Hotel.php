<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Service;
use backend\modules\referenceBooks\models\TypeHotel;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\HotelService;
use backend\modules\referenceBooks\models\Address;
use backend\modules\referenceBooks\models\Rating;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Category;
use backend\modules\blog\entities\HotelReview AS HR;
class Hotel extends ActiveRecord {

    public static function tableName() {
        return 'hotel';
    }

    public function rules() {
        return [
            [['country_id', 'city_id', 'category_id', 'type_id', 'view_id', 'name', 'alias', 'status', 'sync'], 'required'],
            [['country_id', 'city_id', 'category_id', 'type_id', 'view_id'], 'integer'],
            [['name', 'alias'], 'string', 'length' => [0, 255]],
            [['status', 'sync'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hid' => 'ID отеля (API)',
            'media_id' => 'Фото',
            'country_id' => 'Страна',
            'city_id' => 'Город',
            'category_id' => 'Категория',
            'type_id' => 'Тип отеля',
            'view_id' => 'Вид отдыха',
            'name' => 'Название',
            'alias' => 'Алиас',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

    public function getHotelService() {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])
                        ->viaTable('hotel_service', ['hotel_id' => 'id']);
    }

    public function getCountries() {
        return $this->hasOne(Country::className(), ['cid' => 'country_id']);
    }

    public function getCites() {
        return $this->hasOne(City::className(), ['cid' => 'city_id']);
    }

    public function getService() {
        return $this->hasMany(Service::className(), ['id' => 'cid']);
    }

    public function getHS() {
        return $this->hasMany(HotelService::className(), ['hotel_id' => 'id']);
    }

    public function getAddress() {
        return $this->hasOne(Address::className(), ['hotel_id' => 'id']);
    }

    public function getRating() {
        return $this->hasMany(Rating::className(), ['hotel_id' => 'hid']);
    }

    public function getMedia() {
        return $this->hasOne(Mediafile::className(), ['id' => 'media_id']);
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getReviews() {
        return $this->hasMany(HotelReview::className(), ['hotel_id' => 'id']);
    }

    public function getBlogHotelReviews() {
        return $this->hasOne(HR::className(), ['hotel_id' => 'id']);
    }

}
