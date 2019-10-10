<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use yii\base\InvalidParamException;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_confirm;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);

        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password','password_confirm'], 'required'],
            [['password','password_confirm'], 'trim'],
            ['password', 'string', 'min' => 8],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9_-]{4,18}$/', 'message' => 'Пароль далжен состоять из английских символов и цифр и быть длинее 8 знаков'],
            ['password_confirm','compare','compareAttribute' => 'password','message' => 'Пароли не совпадают']
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'password_confirm' => 'Потверждение пароля',
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
