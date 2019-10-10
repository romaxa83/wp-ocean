<?php

namespace backend\modules\user\forms;

use backend\modules\user\entities\Passport;
use backend\modules\user\helpers\DateFormat;
use yii\base\Model;

class PassportSignupForm extends Model
{
    public $first_name;
    public $last_name;

    public function rules() {
        return [
            [['first_name','last_name'],'required'],
            [['first_name','last_name'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
        ];
    }
}