<?php

namespace app\modules\staticBlocks;

use yii\web\AssetBundle;

class StaticBlocksAsset extends AssetBundle {

    public $sourcePath = '@static-blocks-assets';

    public $css = [
        'css/static-blocks.css'
    ];

    public $js = [
        'js/static-blocks.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}