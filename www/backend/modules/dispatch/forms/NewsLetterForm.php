<?php

namespace backend\modules\dispatch\forms;

use yii\base\Model;
use backend\modules\user\helpers\DateFormat;
use backend\modules\dispatch\entities\NewsLetter;

class NewsLetterForm extends Model
{
    public $subject;
    public $body;
    public $send;

    public function __construct(NewsLetter $letter = null,array $config = [])
    {
        if($letter){
            $this->subject = $letter->subject;
            $this->body = $letter->body;
            $this->send = DateFormat::viewNewsLetterEdit($letter->send);
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['subject','body','send'], 'required'],
            [['subject', 'body'], 'string'],
            ['send', 'match', 'pattern' => '/^[0-9]{2}.[0-9]{2}.[0-9]{4}, [0-9]{2}:[0-9]{2}$/', 'message' => 'Дата должна быть в формате "01.12.2018, 12:00"'],
            ['send','validateSend']
        ];
    }

    public function attributeLabels()
    {
        return [
            'subject' => 'Тема рассылки',
            'body' => 'Тело рассылки',
            'send' => 'Время рассылки',
        ];
    }

    public function validateSend($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strtotime($this->send) < time()){
                $this->addError($attribute, 'Дата отправки не может быть в прошлом');
            }
        }
    }
}