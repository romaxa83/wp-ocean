<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\LoginForm;

class InfoModal extends Widget
{
    public $template;

    public function run()
    {
        switch ($this->template) {
            case 'confirm-sign-up':
                $view = $this->template;
                break;

            case 'confirm-sign-up-success':
                $view = $this->template;
                break;

            default:
                throw new \DomainException('Неверно указан template,либо его не существует');
        }

        return $this->render($view);
    }
}