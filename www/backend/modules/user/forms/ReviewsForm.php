<?php

namespace backend\modules\user\forms;

use yii\base\Model;
use backend\modules\user\entities\Reviews;

class ReviewsForm extends Model
{
    public $hotel_id;
    public $user_id;
    public $text;
    public $rating;
    public $from_date;
    public $to_date;

    public $media_id;

    public $verifyCode;

    public function __construct(Reviews $reviews = null, $config = [])
    {
        if($reviews){
            $this->text = $reviews->text;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['text','rating','from_date','to_date'],'required'],
            [['text'],'string'],
            [['rating'],'number'],
            [['from_date','to_date','user_id','hotel_id','media_id'],'safe'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'user_id' => 'Имя пользователя',
            'hotel_id' => 'Отель',
            'text' => 'Текст',
            'birthday' => 'День рождения',
            'rating' => 'Рейтинг',
            'from_date' => 'Дата прибывание',
            'to_date' => 'Дата прибывание по',
        ];
    }
}