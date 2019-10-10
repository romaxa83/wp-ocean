<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use frontend\models\PasswordResetRequestForm;

class PasswordResetRequestModalWidget extends Widget
{
    public function run() {
        if (Yii::$app->user->isGuest) {
            $model = new PasswordResetRequestForm();
            return $this->render('password-reset-request-modal', [
                'model' => $model,
            ]);
        } else {

            return $this->render('/');
        }
    }
}