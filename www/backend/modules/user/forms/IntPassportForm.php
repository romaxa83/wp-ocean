<?php

namespace backend\modules\user\forms;

use backend\modules\user\helpers\DateFormat;
use yii\base\Model;
use backend\modules\user\entities\IntPassport;

class IntPassportForm extends Model
{
    public $first_name;
    public $last_name;
    public $sex;
    public $birthday;
    public $series;
    public $number;
    public $issued;
    public $issued_date;
    public $expired_date;
    public $media_id;

    public function __construct(IntPassport $passport = null, $config = [])
    {
        if($passport){
            $this->first_name = $passport->first_name;
            $this->last_name = $passport->last_name;
            $this->sex = $passport->sex;
            $this->birthday = DateFormat::forView($passport->birthday);
            $this->series = $passport->series;
            $this->number = $passport->number;
            $this->issued = $passport->issued;
            $this->issued_date = DateFormat::forView($passport->issued_date);
            $this->expired_date = DateFormat::forView($passport->expired_date);
            $this->media_id = $passport->media_id;

        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['first_name', 'last_name','sex','birthday','series','number','issued','issued_date','expired_date'], 'required'],
            [['first_name', 'last_name'], 'string','max' => 250],
            [['series'], 'string','max' => 5],
            [['issued'], 'string','max' => 1000],
            [['number','sex'] ,'integer'],
            [['birthday','issued_date','expired_date'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'birthday' => 'День рождения',
            'series' => 'Серия',
            'number' => 'Номер',
            'issued' => 'Кем выдан',
            'issued_date' => 'Когда выдан',
            'expired_date' => 'Срок действия',
        ];
    }
}