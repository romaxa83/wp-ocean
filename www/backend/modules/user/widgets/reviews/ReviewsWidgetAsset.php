<?php

namespace backend\modules\user\widgets\reviews;

use yii\web\AssetBundle;

class ReviewsWidgetAsset extends AssetBundle {

    public $sourcePath = '@reviews-widget-assets';
    public $js = [
        'js/reviews.js',
    ];
    public $css = [
        'css/reviews.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}