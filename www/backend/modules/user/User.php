<?php

namespace backend\modules\user;

use app\modules\user\UserAsset;
use yii\base\Module;
/**
 * Класс определения модуля 'user'
 */
class User extends Module
{
    /**
     *
     * @see https://www.yiiframework.com/doc/api/2.0/yii-base-module#$controllerNamespace-detail
     * @var string В свойстве храниться пространство имен модуля
     */
    public $controllerNamespace = 'backend\modules\user\controllers';

    /**
     * Инициализация модуля
     * @see https://www.yiiframework.com/doc/api/2.0/yii-base-module#init()-detail
     */
    public function init()
    {
        parent::init();
        $this->setAliases([
            '@user-assets' => __DIR__ . '/assets'
        ]);
        UserAsset::register(\Yii::$app->view);
    }
}
