<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\City;
use backend\modules\filemanager\models\Mediafile;

class Entertainment extends ActiveRecord {

    public static function tableName() {
        return 'entertainment';
    }

    public function rules() {
        return [
            [['country_id', 'city_id', 'media_id', 'name', 'description', 'status'], 'required'],
            [['country_id', 'city_id', 'media_id'], 'integer'],
            ['name', 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'country_id' => 'Cтрана',
            'city_id' => 'Город',
            'media_id' => 'Фото',
            'name' => 'Название',
            'description' => 'Описание',
            'status' => 'Статус'
        ];
    }

    public function getCountry() {
        return $this->hasOne(Country::className(), ['cid' => 'country_id']);
    }

    public function getCity() {
        return $this->hasOne(City::className(), ['cid' => 'city_id']);
    }

    public function getMedia() {
        return $this->hasOne(Mediafile::className(), ['id' => 'media_id']);
    }

}
