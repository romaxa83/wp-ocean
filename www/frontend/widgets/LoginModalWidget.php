<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\LoginForm;

class LoginModalWidget extends Widget
{
    public function run() {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('login-modal', [
                'model' => $model,
            ]);
        } else {
            return $this->render('/');
        }
    }
}