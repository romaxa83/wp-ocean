<?php

namespace backend\modules\specials\models;

use yii\db\ActiveRecord;

class Special extends ActiveRecord {
    public static function tableName() {
        return '{{%specials}}';
    }

    public function rules() {
        return [
            [['name', 'status', 'from_datetime', 'to_datetime'], 'required'],
            ['name', 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            [['from_datetime', 'to_datetime'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['to_datetime', 'compare', 'compareAttribute' => 'from_datetime', 'operator' => '>'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'status' => 'Статус',
            'from_datetime' => 'Дата начала',
            'to_datetime' => 'Дата окончания'
        ];
    }
}