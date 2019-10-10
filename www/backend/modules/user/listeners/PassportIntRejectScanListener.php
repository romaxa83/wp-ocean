<?php

namespace backend\modules\user\listeners;

use backend\modules\dispatch\entities\Notifications;
use backend\modules\user\events\PassportIntRejectScan;

class PassportIntRejectScanListener extends BaseListener
{

    public function handle(PassportIntRejectScan $event) : void
    {
        $notification = $this->notifications_repository->getByAlias('verify-passport-int-error');
        $email = ($event->passport->user)[0]['email'];
        if($notification->isActive()){
            $sent = $this->mailer->compose()
                ->setFrom(\Yii::$app->params['SMTP_from'])
                ->setTo($email)
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
        $var_key['{series}'] = $event->passport->series;
        $var_key['{number}'] = $event->passport->number;

        return str_replace($var,array_values($var_key),$notification->text);
    }
}