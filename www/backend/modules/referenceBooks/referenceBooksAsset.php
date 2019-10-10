<?php

namespace backend\modules\referenceBooks;

use yii\web\AssetBundle;

class referenceBooksAsset extends AssetBundle {

    public $sourcePath = '@reference-books-assets';
    public $css = [
        'css/reference-books.css'
    ];
    public $js = [
        'js/reference-books.js',
        'js/tour.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
