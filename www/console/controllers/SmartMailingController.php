<?php

namespace console\controllers;

use backend\modules\user\entities\SmartMailing;
use yii\console\Controller;

class SmartMailingController extends Controller
{
    /**
     * Запускает smart.
     * @package app\commands
     */
    public function actionStart()
    {
        $smart = SmartMailing::find()
            ->where(['status' => SmartMailing::STATUS_SEARCH])
            ->all();

        dd($smart);
    }
}