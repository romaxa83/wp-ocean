<?php

namespace backend\modules\user\forms;

use backend\modules\user\entities\Passport;
use backend\modules\user\helpers\DateFormat;
use yii\base\Model;

class PassportForm extends Model
{
    public $first_name;
    public $last_name;
    public $patronymic;
    public $birthday;
    public $series;
    public $number;
    public $issued;
    public $issued_date;
    public $media_id;

    public function __construct(Passport $passport = null, $config = [])
    {
        if($passport){
            $this->first_name = $passport->first_name;
            $this->last_name = $passport->last_name;
            $this->patronymic = $passport->patronymic;
            $this->birthday = DateFormat::forView($passport->birthday);
            $this->series = $passport->series;
            $this->number = $passport->number;
            $this->issued = $passport->issued;
            $this->issued_date = DateFormat::forView($passport->issued_date);
            $this->media_id = $passport->media_id;

        }
        parent::__construct($config);
    }

    public function rules() {
        return [
//            [['first_name','last_name','patronymic','birthday','series','number','issued','issued_date'],'required'],
            [['first_name','last_name'],'required'],
            [['first_name','last_name','patronymic','series','issued'],'string'],
            [['number','media_id'],'number'],
            [['series'],'string','max' => 2,'message' => 'Серия должна состоять из двух букв'],
            [['birthday','issued_date'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'patronymic' => 'Отчество',
            'birthday' => 'День рождения',
            'series' => 'Серия',
            'number' => 'Номер',
            'issued' => 'Кем выдан',
            'issued_date' => 'Когда выдан',
        ];
    }
}