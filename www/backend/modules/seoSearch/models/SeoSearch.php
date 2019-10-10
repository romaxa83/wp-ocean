<?php

namespace backend\modules\seoSearch\models;

use Yii;
use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\DeptCity;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\SeoMeta;

class SeoSearch extends ActiveRecord {

    public static function tableName() {
        return 'seo_search';
    }

    public function rules() {
        return [
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'country_id' => 'Страна',
            'dept_city_id' => 'Город вылета',
            'city_id' => 'Курорт',
            'status' => 'Статус'
        ];
    }

    public function getCountry() {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getDeptCity() {
        return $this->hasOne(DeptCity::className(), ['id' => 'dept_city_id']);
    }

    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getSeo() {
        return $this->hasOne(SeoMeta::className(), ['page_id' => 'id'])->where(['seo_meta.alias' => 'seo_search']);
    }

}
