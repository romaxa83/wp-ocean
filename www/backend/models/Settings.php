<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Settings extends ActiveRecord {

    public static function tableName() {
        return 'settings';
    }

    public function rules() {
        return [
            [['name', 'body'], 'required']
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'body' => 'Значение'
        ];
    }

}
