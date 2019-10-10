<?php

namespace backend\modules\filter;

use Yii;
use yii\base\Module;
use backend\modules\filter\FilterAsset;

class Filter extends Module {

    public $controllerNamespace = 'backend\modules\filter\controllers';

    public function init() {
        parent::init();
        $this->setAliases([
            '@filter-assets' => __DIR__ . '/assets'
        ]);
        FilterAsset::register(Yii::$app->view);
    }

}
