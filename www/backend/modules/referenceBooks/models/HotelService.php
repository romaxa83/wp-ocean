<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Service;
use backend\modules\referenceBooks\models\Hotel;

class HotelService extends ActiveRecord {

    public static function tableName() {
        return 'hotel_service';
    }

    public function rules() {
        return [
            [['hotel_id', 'service_id', 'type', 'price'], 'required'],
            [['hotel_id', 'service_id'], 'integer'],
            ['price', 'number'],
            [['type'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hotel_id' => 'ID отеля',
            'service_id' => 'ID сервиса',
            'type' => 'Тип',
            'price' => 'Цена'
        ];
    }

    public function getService() {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

}
