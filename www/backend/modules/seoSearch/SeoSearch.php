<?php

namespace backend\modules\seoSearch;

use yii\base\Module;

class SeoSearch extends Module {

    public $controllerNamespace = 'backend\modules\seoSearch\controllers';

    public function init() {
        parent::init();
        $this->setAliases([
            '@seo-search-assets' => __DIR__ . '/assets'
        ]);
        SeoSearchAsset::register(\Yii::$app->view);
    }

}
