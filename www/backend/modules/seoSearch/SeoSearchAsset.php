<?php

namespace backend\modules\seoSearch;

use yii\web\AssetBundle;

class SeoSearchAsset extends AssetBundle {

    public $sourcePath = '@seo-search-assets';
    public $css = [
        'css/seo-search.css'
    ];
    public $js = [
        'js/seo-search.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
