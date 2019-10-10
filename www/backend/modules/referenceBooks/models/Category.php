<?php

namespace backend\modules\referenceBooks\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord {

    public static function tableName() {
        return 'category';
    }

    public function rules() {
        return [
            [['code', 'name', 'status'], 'required'],
            [['code', 'name'], 'string', 'length' => [0, 255]],
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
