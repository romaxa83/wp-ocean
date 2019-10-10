<?php

namespace app\modules\user;

use yii\web\AssetBundle;

class UserAsset extends AssetBundle {

    public $sourcePath = '@user-assets';

    public $css = [
        'css/user.css'
    ];

    public $js = [
        'js/user.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}