<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class Offer extends ActiveRecord {

    public static function tableName() {
        return 'offer';
    }

    public function rules() {
        return [
            [['hotel_id', 'operator_id', 'oid', 'code', 'craft', 'line', 'port_from', 'port_to', 'date_begin', 'date_end', 'sync'], 'required'],
            [['hotel_id', 'operator_id'], 'number'],
            [['oid', 'code', 'craft', 'line', 'port_from', 'port_to'], 'string', 'length' => [0, 255]],
            ['sync', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hotel_id' => 'ID отеля',
            'operator_id' => 'ID оператора',
            'oid' => 'ID предложения (API)',
            'code' => 'Код',
            'craft' => 'Самолет',
            'line' => 'Линия',
            'port_from' => 'Порт отправления',
            'port_to' => 'Порт прибытия',
            'date_begin' => 'Дата',
            'date_end' => 'Дата',
            'sync' => 'Синхронизация'
        ];
    }

}
