<?php


namespace backend\modules\menuBuilder;


use Yii;
use yii\base\Module;

class MenuBuilder extends Module
{
    public $controllerNamespace = 'backend\modules\menuBuilder\controllers';

    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config/config.php');

        $this->setAliases([
            '@menu-assets' => __DIR__ . '/assets'
        ]);

        MenuBuilderAsset::register(Yii::$app->view);
    }
}