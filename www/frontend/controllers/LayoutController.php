<?php

namespace frontend\controllers;

use Yii;

class LayoutController extends BaseController {

    public function actionIndex() {
        $get = Yii::$app->request->get();
        if (!file_exists(Yii::getAlias('@app') . '/web/layout/' . $get['action'] . '.php')) {
            die('404 not found');
        }
        return $this->render('../../web/layout/' . $get['action']);
    }

}
