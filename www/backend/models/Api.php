<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Api extends ActiveRecord {

    public static function tableName() {
        return 'api';
    }

    public function rules() {
        return [
            [['name', 'href'], 'required']
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'href' => 'Ссылка',
            'token' => 'Токен',
        ];
    }

}
