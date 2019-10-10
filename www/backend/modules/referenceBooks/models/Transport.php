<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class Transport extends ActiveRecord {

    public static function tableName() {
        return 'transport';
    }

    public function rules() {
        return [
            [['code', 'name', 'status'], 'required'],
            ['code', 'string', 'length' => [0, 255]],
            ['name', 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'name' => 'Название',
            'status' => 'Статус'
        ];
    }

}
