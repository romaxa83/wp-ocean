<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use frontend\models\ResetPasswordForm;

class PasswordResetModalWidget extends Widget
{
    public $token;

    public function run() {
        if (Yii::$app->user->isGuest) {
            $model = new ResetPasswordForm($this->token);
            return $this->render('password-reset-modal', [
                'model' => $model,
                'token' => $this->token
            ]);
        } else {

            return $this->render('/');
        }
    }
}