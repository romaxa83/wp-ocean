<?php

namespace common\models;

use backend\modules\blog\forms\CompositeForm;
use backend\modules\user\forms\PassportSignupForm;


class SignupForm extends CompositeForm
{

    public $email;
    public $phone;
    public $password;

    public $confidentiality;
    public $password_confirm;

    public function __construct(array $config = [])
    {
        $this->passport = new PassportSignupForm();
        parent::__construct($config);
    }

    public function rules() {
        return [
            [['email','phone','password','password_confirm','confidentiality'], 'required'],
//            ['confidentiality', 'compare','compareValue' => '1','message' => 'Политику конфиденциальности необходимо отметить'],
            [['email','phone','password','password_confirm'], 'trim'],
            ['password_confirm','compare','compareAttribute' => 'password','message' => 'Пароли не совпадают'],
            [['password'], 'string','min' => 8,'max' => 250],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{4,18}$/', 'message' => 'Пароль далжен состоять из английских символов и цифр и быть длинее 8 знаков'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            ['phone', 'validatePhone']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'password_confirm' => 'Потверждение пароль',
            'confidentiality' => 'Политика конфиденциальности',
        ];
    }

    protected function internalForms(): array
    {
        return ['passport'];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByEmail($this->email)?true:false;
            if ($user){
                $this->addError($attribute, 'Пользователь с такой почтой уже зарегистрирован');
            }
        }
    }

    public function validatePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByPhone($this->phone)?true:false;
            if ($user){
                $this->addError($attribute, 'Пользователь с таким номером телефоном уже зарегистрирован');
            }
        }
    }
}