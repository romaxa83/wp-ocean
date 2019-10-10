<?php

namespace backend\modules\user\forms;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\Country;

class SmartMailingForm extends Model
{
    public $country_id;
    public $with;
    public $to;
    public $persons;

    public function rules():array
    {
        return [
            [['country_id','with','to','persons'], 'required'],
            [['country_id'], 'integer',],
            [['persons'], 'integer','min' => 1 ,'message' => 'Кол-во людей не может быть отрицательным'],
            [['with','to','created'], 'safe',],
        ];
    }

    public function attributeLabels():array
    {
        return [
            'country_id' => 'Страна',
            'with' => 'Дата с',
            'to' => 'Дата по',
            'persons' => 'Кол-во человек',
        ];
    }

    public function getCountryList()
    {
        return ArrayHelper::map(Country::find()->all(),'id','name');
    }
}