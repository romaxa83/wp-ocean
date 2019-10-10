<?php

namespace backend\modules\filter;

use yii\web\AssetBundle;

class FilterAsset extends AssetBundle {

    public $sourcePath = '@filter-assets';
    public $css = [
        'css/filter.css'
    ];
    public $js = [
        'js/filter.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
