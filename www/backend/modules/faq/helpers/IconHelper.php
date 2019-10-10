<?php

namespace backend\modules\faq\helpers;

use yii\helpers\Url;
use backend\modules\filemanager\models\Mediafile;

class IconHelper
{
    public static function iconUrl($model,$fronted = false)
    {
        if($model && ($model instanceof Mediafile)){
            if($fronted){
                return '/admin' . Url::base() . $model->url;
            }
            return Url::base() . $model->url;
        }

        if($fronted){
            return '/admin' . Url::base() . '/img/not-images.png';
        }
        return Url::base() . '/img/not-images.png';
    }
}