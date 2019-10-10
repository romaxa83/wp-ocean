<?php

namespace backend\modules\user\forms;

use backend\modules\user\services\RbacService;
use common\models\User;
use backend\modules\blog\forms\CompositeForm;


class UserForm extends CompositeForm
{
    const EDIT_USER = 'editUser';
    const CREATE_USER = 'createUser';

    public $role;

    public $email;
    public $phone;
    public $password;

    public $_user;

    public function __construct(User $user = null,array $config = [])
    {
        if($user){
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->role = $user->getRole();

            $this->passport = new PassportForm($user->passport);
            $this->_user = $user;
        } else {
            $this->passport = new PassportForm();
        }
        parent::__construct($config);
    }

    public function rules() {
        return [

            [['phone','role'], 'required','on' => self::EDIT_USER],
            [['email','phone'], 'trim', 'on' => self::EDIT_USER],
            ['email', 'email', 'on' => self::EDIT_USER],
            ['email', 'validateEmail','on' => self::EDIT_USER],
            ['phone', 'validatePhone','on' => self::EDIT_USER],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{4,18}$/',
                'message' => 'Пароль далжен состоять из английских символов и цифр и быть длинее 4 знаков','on' => self::EDIT_USER],

            [['email','phone','password','role'], 'required','on' => self::CREATE_USER],
            [['email','phone'], 'trim','on' => self::CREATE_USER],
            ['email', 'email','on' => self::CREATE_USER],
            ['email', 'validateEmail','on' => self::CREATE_USER],
            ['phone', 'validatePhone','on' => self::CREATE_USER],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{4,18}$/',
                'message' => 'Пароль далжен состоять из английских символов и цифр и быть длинее 4 знаков','on' => self::CREATE_USER],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'password_confirm' => 'Потверждение пароль',
            'role' => 'Роль',
        ];
    }

    protected function internalForms(): array
    {
        return ['passport'];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByEmail($this->email,!(empty($this->_user))?$this->_user->id:null)?true:false;
            if ($user){
                $this->addError($attribute, 'Пользователь с такой почтой уже зарегистрирован');
            }
        }
    }
    public function validatePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByPhone($this->phone,!(empty($this->_user))?$this->_user->id:null)?true:false;
            if ($user){
                $this->addError($attribute, 'Пользователь с таким номером телефоном уже зарегистрирован');
            }
        }
    }

    public function getRoles()
    {
        return (new RbacService())->getAllRole(['admin']);
    }
}