<?php

namespace backend\modules\user\listeners;

use backend\modules\dispatch\entities\Notifications;
use backend\modules\user\events\UserSignUpByNetwork;

class UserSignUpByNetworkListener extends BaseListener
{
    public function handle(UserSignUpByNetwork $event) : void
    {
        $notification = $this->notifications_repository->getByAlias('sign-up-by-network');
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

        $var_key['{first_name}'] = $event->passport->first_name;
        $var_key['{last_name}'] = $event->passport->last_name;
        $var_key['{login}'] = $event->user->email;
        $var_key['{password}'] = $event->password;
        $var_key['{network}'] = $event->network;

        return str_replace($var,array_values($var_key),$notification->text);
    }
}