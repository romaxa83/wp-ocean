<?php

namespace backend\modules\filemanager\assets;

use yii\web\AssetBundle;

class FilemanagerAsset extends AssetBundle
{
    public $sourcePath = '@filemanager/assets/source';
    public $css = [
        'css/filemanager.css',
    ];
    public $js = [
        'js/filemanager.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset',
    ];
}
