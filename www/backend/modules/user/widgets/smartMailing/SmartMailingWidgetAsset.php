<?php

namespace backend\modules\user\widgets\smartMailing;

use yii\web\AssetBundle;

class SmartMailingWidgetAsset extends AssetBundle {

    public $sourcePath = '@smartMailing-widget-assets';
    public $js = [
        'js/smart-mailing.js',
    ];
    public $css = [
        'css/smart-mailing.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}