<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class Operator extends ActiveRecord {

    public static function tableName() {
        return 'operator';
    }

    public function rules() {
        return [
            [['oid', 'name', 'url', 'countries', 'currencies', 'status', 'sync'], 'required'],
            ['oid', 'number'],
            [['name', 'url'], 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['sync', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'oid' => 'ID оператора (API)',
            'name' => 'Название',
            'url' => 'Ссылка',
            'countries' => 'Страны',
            'currencies' => 'Валюта',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

}
