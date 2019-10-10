<?php
namespace frontend\models;

use backend\modules\dispatch\entities\Notifications;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Пользователь с такой почтой не зарегистрирован'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $notification = $this->getNotification();
        if($notification->isActive()){

            return Yii::$app
                ->mail
                ->compose()
                ->setFrom(\Yii::$app->params['SMTP_from'])
                ->setTo($this->email)
                ->setSubject($notification->name)
                ->setHtmlBody($this->generateLetter($user,$notification))
                ->send();
        }

        return false;
    }

    public function generateLetter($user,Notifications $notification) : string
    {
        $link = Yii::$app->urlManager->createAbsoluteUrl(['/','modal' => 'reset-password', 'token' => $user->password_reset_token]);

        $var = explode(',',$notification->variables);
        $var_key = array_flip($var);

        $var_key['{first_name}'] = $user->passport->first_name;
        $var_key['{last_name}'] = $user->passport->last_name;
        $var_key['{reset_link}'] = $link;

        return str_replace($var,array_values($var_key),$notification->text);
    }

    public function getNotification() : Notifications
    {
        return Notifications::findOne(['alias' => 'reset-password']);
    }
}
