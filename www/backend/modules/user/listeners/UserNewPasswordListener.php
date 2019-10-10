<?php

namespace backend\modules\user\listeners;

use backend\modules\dispatch\entities\Notifications;
use backend\modules\user\events\PassportRejectScan;
use backend\modules\user\events\UserNewPassword;

class UserNewPasswordListener extends BaseListener
{

    public function handle(UserNewPassword $event) : void
    {
        $notification = $this->notifications_repository->getByAlias('new-password');
        if($notification->isActive()){
            $sent = $this->mailer->compose()
                ->setFrom(\Yii::$app->params['SMTP_from'])
                ->setTo($event->user->email)
                ->setSubject($notification->name)
                ->setHtmlBody($this->generateLetter($event,$notification))
                ->send();
            if(!$sent){
                throw new \RuntimeException('Ошибка отправки почты');
            }
        }
        return;
    }

    public function generateLetter($event,Notifications $notification) : string
    {
        $var = explode(',',$notification->variables);
        $var_key = array_flip($var);

        $var_key['{first_name}'] = $event->user->passport->first_name;
        $var_key['{last_name}'] = $event->user->passport->last_name;
        $var_key['{new_password}'] = $event->password;

        return str_replace($var,array_values($var_key),$notification->text);
    }
}