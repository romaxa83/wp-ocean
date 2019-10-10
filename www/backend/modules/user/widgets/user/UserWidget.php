<?php

namespace backend\modules\user\widgets\user;

use common\models\User;
use yii\base\Widget;
use common\models\LoginForm;
use common\models\SignupForm;
use backend\modules\user\forms\UserFotoForm;
use backend\modules\user\forms\PasswordForm;
use backend\modules\user\forms\IntPassportForm;

class UserWidget extends Widget
{
    /*
     * template указывает какая форма будет подгружена
     * варианты :
     * - signup - форма регистрации
     * - passport - форма для паспортных данных
     * - int-passport - форма для данных загран паспорта
     */
    public $template;

    /*
     * модель формы
     */
    public $form;

    /*
     * кол-во выводимых форм
     * используеться для загран паспорта
     */
    public $countForms = 1;

    public $user_id = null;

    public function init()
    {
        parent::init();

        \Yii::setAlias('@user-widget-assets',  \Yii::getAlias('@backend').'/modules/user/widgets/user/assets');

        UserWidgetAsset::register(\Yii::$app->view);
    }

    public function run()
    {
        $view = $this->template;
        switch ($this->template) {
            case 'signup':
                $model = new SignupForm();
                break;
            case 'passport':
                $model = $this->form;
                break;
            case 'int-passport':
                $model = new IntPassportForm();
                break;
            case 'change-password':
                $model = new PasswordForm($this->user_id);
                break;
            case 'phone-email':
                $model = $this->form;
                break;
            case 'login':
                $model = new LoginForm();
                break;
            case 'set-avatar':
                $model = new UserFotoForm($this->getUser());
                break;
            default:
                throw new \DomainException('Неверно указан template');
        }

        return $this->render($view,[
            'model' => $model,
            'countForms' => $this->countForms,
            'user' => $this->getUser()
        ]);
    }

    public function getUser()
    {
        if($this->user_id){
            return User::findOne($this->user_id);
        }
        return false;
    }
}
