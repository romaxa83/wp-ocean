<?php

namespace app\modules\dispatch\assets;

use yii\web\AssetBundle;


class DispatchAsset extends AssetBundle {

    public $sourcePath = '@backend/modules/dispatch/assets';

    public $css = [
        'css/dispatch.css'
    ];

    public $js = [
        'js/dispatch.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}