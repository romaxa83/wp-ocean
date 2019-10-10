<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/icheck/red.css',
        'css/site.css',
        'css/icheck/red.css',
    ];
    public $js = [

        'js/main.js',
        'js/icheck.js',
        'js/jquery.liTranslit.js',
        '//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'backend\assets\JqueryUIAsset'
    ];

}
