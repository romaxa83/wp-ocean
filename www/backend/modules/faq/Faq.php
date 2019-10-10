<?php

namespace backend\modules\faq;

class Faq extends \yii\base\Module
{
    /**
     * В свойстве храниться пространство имен модуля
     * @see https://www.yiiframework.com/doc/api/2.0/yii-base-module#$controllerNamespace-detail
     * @var string
     */
    public $controllerNamespace = 'backend\modules\faq\controllers';

    /**
     * Инициализация модуля
     * @see https://www.yiiframework.com/doc/api/2.0/yii-base-module#init()-detail
     */
    public function init()
    {
        parent::init();
        $this->setAliases([
            '@faq-assets' => __DIR__ . '/assets'
        ]);
    }
}