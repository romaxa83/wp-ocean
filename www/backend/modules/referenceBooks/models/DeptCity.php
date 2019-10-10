<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class DeptCity extends ActiveRecord {

    public static function tableName() {
        return 'dept_city';
    }

    public function rules() {
        return [
            [['cid', 'name', 'status', 'sync'], 'required'],
            ['cid', 'number'],
            ['name', 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            ['sync', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false]
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cid' => 'ID Города (API)',
            'name' => 'Название',
            'status' => 'Статус',
            'sync' => 'Синхронизация'
        ];
    }

}
