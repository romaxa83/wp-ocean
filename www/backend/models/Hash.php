<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\Api;

class Hash extends ActiveRecord {

    public static function tableName() {
        return 'hash';
    }

    public function rules() {
        return [
            [['hash', 'cache'], 'required']
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'api_id' => 'ID API',
            'link' => 'Ссылка',
            'hash' => 'Хеш',
        ];
    }

    public function getUser() {
        return $this->hasOne(Api::className(), ['api_id' => 'id']);
    }

}
