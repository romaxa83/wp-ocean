<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\SignupForm;

class RegModalWidget extends Widget
{
    public function run() {
        if (Yii::$app->user->isGuest) {
            $model = new SignupForm();
            return $this->render('reg-modal', [
                'model' => $model,
            ]);
        } else {

            return $this->render('/');
        }
    }
}