<?php

namespace backend\modules\staticBlocks;

class StaticBlocks extends \yii\base\Module
{

    public $controllerNamespace = 'backend\modules\staticBlocks\controllers';

    /**
     * Инициализация модуля
     * @see https://www.yiiframework.com/doc/api/2.0/yii-base-module#init()-detail
     */
    public function init()
    {
        parent::init();
        $this->setAliases([
            '@static-blocks-assets' => __DIR__ . '/assets'
        ]);
    }
}