<?php

namespace common\bootstrap;

use yii\di\Container;
use yii\mail\MailerInterface;
use yii\base\BootstrapInterface;
use backend\modules\user\events\PassportVerify;
use backend\modules\user\events\UserNewPassword;
use backend\modules\user\events\UserSignUpConfirm;
use backend\modules\user\events\PassportRejectScan;
use backend\modules\user\events\UserSignUpByNetwork;
use backend\modules\user\events\UserSignUpRequested;
use backend\modules\user\dispatchers\EventDispatcher;
use backend\modules\user\events\PassportIntRejectScan;
use backend\modules\user\listeners\PassportVerifyListener;
use backend\modules\user\listeners\UserNewPasswordListener;
use backend\modules\user\dispatchers\SimpleEventDispatcher;
use backend\modules\user\listeners\UserSignUpConfirmListener;
use backend\modules\user\listeners\PassportRejectScanListener;
use backend\modules\user\listeners\UserSignUpByNetworkListener;
use backend\modules\user\listeners\UserSignupRequestedListener;
use backend\modules\user\listeners\PassportIntRejectScanListener;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app) : void
    {
        $container = \Yii::$container;

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mail;
        });

        /*
         * в диспетчер передаеться массив,где
         * ключ название события(в ввиде класса события)
         * значение - массив обработчиков(можно добавлять другие обработчики для одного события)
         */
        $container->setSingleton(EventDispatcher::class,function(Container $container){
            return new SimpleEventDispatcher($container,[
                UserSignUpRequested::class => [UserSignupRequestedListener::class],
                UserSignUpByNetwork::class => [UserSignUpByNetworkListener::class],
                PassportVerify::class => [PassportVerifyListener::class],
                PassportRejectScan::class => [PassportRejectScanListener::class],
                PassportIntRejectScan::class => [PassportIntRejectScanListener::class],
                UserNewPassword::class => [UserNewPasswordListener::class],
                UserSignUpConfirm::class => [UserSignUpConfirmListener::class]
            ]);
        });
    }
}