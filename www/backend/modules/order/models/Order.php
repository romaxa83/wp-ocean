<?php

namespace backend\modules\order\models;

use Yii;
use yii\db\ActiveRecord;
use himiklab\yii2\recaptcha\ReCaptchaValidator3;

class Order extends ActiveRecord {

    public $reCaptcha;

    public static function tableName() {
        return 'order';
    }

    public function rules() {
        return [
            [['hotel_id', 'date', 'offer', 'name', 'phone', 'email', 'price', 'status'], 'required'],
            [['hotel_id', 'price'], 'number'],
            ['email', 'email'],
            ['phone', 'string', 'length' => 12],
            ['info', 'string'],
            [['offer', 'name', 'phone', 'email'], 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            [['reCaptcha'], ReCaptchaValidator3::className(), 'secret' => Yii::$app->params['reCaptcha']['secret'], 'threshold' => 0.5, 'action' => 'order'],
            ['info','safe']
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hotel_id' => 'ID отеля',
            'date' => 'Дата',
            'offer' => 'Предложение',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'comment' => 'Комментарий',
            'price' => 'Цена',
            'status' => 'Статус',
            'info' => 'Детальная информация'
        ];
    }

}
