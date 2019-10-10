<?php

namespace backend\modules\request\models;

use Yii;
use yii\db\ActiveRecord;
use himiklab\yii2\recaptcha\ReCaptchaValidator3;

class Request extends ActiveRecord
{
    const TYPE_REQUEST = 0;
    const TYPE_CONTACT = 1;
    const TYPE_DIRECTIONS = 2;

    const SCENARIO_WITHOUT_CAPTCHA = 'noCaptcha';

    public $reCaptcha;

    public static function tableName() {
        return 'request';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['date', 'name', 'phone', 'email', 'status', 'type', 'reCaptcha'],
            self::SCENARIO_WITHOUT_CAPTCHA => ['date', 'name', 'phone', 'email', 'status', 'type'],
        ];
    }

    public function rules() {
        return [
            [['date', 'name', 'phone', 'email', 'status'], 'required'],
            ['email', 'email'],
            [['type'],'integer'],
            ['phone', 'string', 'length' => 12],
            [['name', 'phone', 'email'], 'string', 'length' => [0, 255]],
            ['status', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            [['reCaptcha'], ReCaptchaValidator3::className(), 'secret' => Yii::$app->params['reCaptcha']['secret'],  'threshold' => 0.5, 'action' => 'request']
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'comment' => 'Комментарий',
            'status' => 'Статус',
            'type' => 'Тип'
        ];
    }

}
