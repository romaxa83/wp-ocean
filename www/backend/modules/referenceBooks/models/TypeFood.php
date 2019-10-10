<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class TypeFood extends ActiveRecord {

    public static function tableName() {
        return 'type_food';
    }

    public function rules() {
        return [
            [['name', 'code', 'description', 'status', 'sync'], 'required'],
            ['code', 'string', 'length' => [0, 255]],
            ['name', 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['sync', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'name' => 'Название',
            'description' => 'Описание',
            'position' => 'Позиция',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

}
