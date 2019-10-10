<?php

namespace console\models;


class SendEmail
{
    /*
        * Метод для отправки рассылки
        * принимает 5-параметра
        * - название шаблона
        * - тема письма
        * - передаваемые параметры
        * - email кому нужно отправить в формате ассоц. массива ['email' => 'name']
        * - флаг(html) - если он указан,значит отправляеться сгенерированый html шаблон
        */
    public static function send(
        $email,
        $subject,
        $body,
        $view = 'body',
        $site_settings=null,
        $flag=null)
    {

//        \Yii::$app->mailer->getView()->params['email'] = $email;
//        \Yii::$app->mailer->getView()->params['site_email'] = $site_settings['mail'];
//        \Yii::$app->mailer->getView()->params['site_phone'] = $site_settings['phone'];

        $path = '@common/mail/layouts/'.$view .'-html.php';

        $result = \Yii::$app->mailer->compose([
            'html' => $path,
        ], ['text' => $body])->setTo($email)
            ->setSubject($subject)
            ->send();

        // Reset layout params
//        \Yii::$app->mailer->getView()->params['email'] = null;
//        \Yii::$app->mailer->getView()->params['site_email'] = null;
//        \Yii::$app->mailer->getView()->params['site_phone'] = null;

        return $result;
    }
}