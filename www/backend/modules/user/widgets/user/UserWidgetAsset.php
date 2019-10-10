<?php

namespace backend\modules\user\widgets\user;

use yii\web\AssetBundle;

class UserWidgetAsset extends AssetBundle {

    public $sourcePath = '@user-widget-assets';
    public $js = [
        'js/user-widget.js',
    ];
    public $css = [
        'css/user-widget.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}