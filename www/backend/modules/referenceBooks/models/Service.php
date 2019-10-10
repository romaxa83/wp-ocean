<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\HotelService;

class Service extends ActiveRecord {

    public static function tableName() {
        return 'service';
    }

    public function rules() {
        return [
            [['code', 'name', 'type', 'status', 'sync'], 'required'],
            [['code', 'name', 'type'], 'string', 'length' => [0, 255]],
            [['status', 'sync'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'name' => 'Название',
            'include' => 'Включено в стоимость',
            'price' => 'Цена',
            'type' => 'Тип',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

    public function getHotels() {
        return $this->hasMany(Hotel::className(), ['id' => 'hotel_id'])
                        ->viaTable('hotel_service', ['service_id' => 'id']);
    }

}
