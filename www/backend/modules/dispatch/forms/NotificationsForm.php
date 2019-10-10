<?php

namespace backend\modules\dispatch\forms;

use yii\base\Model;
use backend\modules\dispatch\entities\Notifications;

class NotificationsForm extends Model
{
    public $name;
    public $text;
    public $variables;

    public function __construct(Notifications $notifications = null,array $config = [])
    {
        if($notifications){
            $this->name = $notifications->name;
            $this->text = $notifications->text;
            $this->variables = $notifications->variables;
        }
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['text','name'], 'required'],
            [['text', 'name','variables'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Тема уведомления',
            'text' => 'Тело уведомления',
            'variables' => 'Доступные переменные',
        ];
    }
}