<?php


namespace backend\modules\menuBuilder;


use yii\web\AssetBundle;

class MenuBuilderAsset extends AssetBundle
{
    public $sourcePath = '@menu-assets';

    public $css = [
        'css/menu-builder.css'
    ];

    public $js = [
        'js/jquery-sortable-min.js',
        'js/menu-builder.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'alexeevdv\yii\BootstrapToggleAsset',
    ];
}