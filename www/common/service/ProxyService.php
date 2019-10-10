<?php

namespace common\service;

use Yii;

class ProxyService {

    public static function getProxy() {
        return Yii::$app->params['proxy'][rand(0, count(Yii::$app->params['proxy']) - 1)];
    }

}
