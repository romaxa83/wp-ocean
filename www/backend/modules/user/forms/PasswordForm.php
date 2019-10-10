<?php

namespace backend\modules\user\forms;

use common\models\User;
use yii\base\Model;

class PasswordForm extends Model
{
    public $password;
    public $password_new;
    public $password_confirm;

    private $user_id;

    public function __construct($user_id,array $config = [])
    {
        parent::__construct($config);
        $this->user_id = $user_id;
    }

    public function rules():array
    {
        return [
            [['password','password_new','password_confirm'], 'required'],
            ['password', 'validatePassword'],
            ['password_confirm','compare','compareAttribute' => 'password_new','message' => 'Пароли не совпадают'],
            [['password_new'], 'string','min' => 4,'max' => 18,],
            ['password_new', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{4,18}$/', 'message' => 'Пароль должен состоять из английских символов и цифр и быть длинее 4 знаков'],
            [['password_new'], 'trim',],
        ];
    }

    public function attributeLabels():array
    {
        return [
            'password' => 'Пароль',
            'password_new' => 'Новый пароль',
            'password_confirm' => 'Потверждения пароля',
        ];
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne($this->user_id);
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Добрый человек, пароль неверный ¯\_(ツ)_/¯');
            }
        }
    }
}