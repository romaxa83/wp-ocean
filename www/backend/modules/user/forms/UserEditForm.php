<?php

namespace backend\modules\user\forms;

use common\models\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $email;
    public $phone;

    public $_user;

    public function __construct(User $user = null,array $config = [])
    {
        if($user){
            $this->email = $user->email;
            $this->phone = $user->phone;

            $this->_user = $user;
        }
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['email','phone'], 'required'],
            [['email','phone'], 'trim'],
            ['email', 'email'],
            [['email'],'validateEmail'],
            ['phone', 'validatePhone']
        ];
    }

    public function attributeLabels():array
    {
        return [
            'email' => 'Email',
            'phone' => 'Телефон',
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByEmail($this->email,$this->_user->id)?true:false;
            if ($user){
                $this->addError($attribute, 'Пользователь с такой почтой уже зарегистрирован');
            }
        }
    }
    public function validatePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByPhone($this->phone,$this->_user->id)?true:false;
            if ($user){
                $this->addError($attribute, 'Пользователь с таким номером телефоном уже зарегистрирован');
            }
        }
    }
}