<?php


namespace backend\modules\referenceBooks\models;


use yii\db\ActiveRecord;

class Region extends ActiveRecord {
    public static function tableName() {
        return 'region';
    }

    public function rules() {
        return [
            ['name', 'string', 'length' => [0, 255]],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Название',
        ];
    }

    public function getCountries() {
        return $this->hasMany(Country::className(), ['region_id' => 'id']);
    }
}