<?php

namespace frontend\controllers\cabinet;

use backend\modules\user\forms\UserEditForm;
use backend\modules\user\forms\UserForm;
use backend\modules\user\forms\UserFotoForm;
use backend\modules\user\repository\UserRepository;
use frontend\controllers\BaseController;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\modules\user\forms\PassportForm;
use backend\modules\user\forms\PasswordForm;
use backend\modules\user\services\UserService;
use backend\modules\user\services\PassportService;
use backend\modules\user\repository\PassportRepository;

class SettingsController extends BaseController
{
    public $layout = 'cabinet';

    private $user_id;
    private $user_service;
    private $user_repository;
    private $passport_service;
    private $passport_repository;

    public function __construct($id, Module $module,
                                UserService $user_service,
                                UserRepository $user_rep,
                                PassportService $passport_service,
                                PassportRepository $passport_rep,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->user_id = Yii::$app->user->identity->id;
        $this->user_service = $user_service;
        $this->user_repository = $user_rep;
        $this->passport_service = $passport_service;
        $this->passport_repository = $passport_rep;
    }

    public function actionIndex()
    {
        $user = $this->user_repository->get($this->user_id);
        $passport = $this->passport_repository->get($user->passport_id);
        $form_passport = new PassportForm($passport);
        $form_user = new UserEditForm($user);
        return $this->render('index',[
            'form_passport' => $form_passport,
            'form_user' => $form_user
        ]);
    }

    public function actionEditPassport()
    {
        $user = $this->user_repository->get($this->user_id);
        $passport = $this->passport_repository->get($user->passport_id);

        $form = new PassportForm($passport);
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            try {
                $this->passport_service->editPassport($form, $user->passport_id);

                Yii::$app->session->setFlash('success', 'Паспортный данные сохранены.');
                return $this->refresh();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->redirect(['cabinet/settings']);
    }

    public function actionChangeEmailPhone()
    {
        $user = $this->user_repository->get($this->user_id);
        $form = new UserEditForm($user);
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            try {
                $this->user_service->editUser($form,$this->user_id);

                Yii::$app->session->setFlash('success', 'Данные были изменены');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['cabinet/settings']);
    }

    public function actionValidateAjaxEditUser() {
        $user = $this->user_repository->get($this->user_id);
        $model = new UserEditForm($user);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionChangePassword($id)
    {
        $form = new PasswordForm($id);
        $post = Yii::$app->request->post();
        if($form->load($post) && $form->validate()){
            try {
                $this->user_service->changePassword($form);

                Yii::$app->session->setFlash('success', 'Пароль был изменен');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['cabinet/settings']);
    }

    public function actionValidateAjaxChangePassword() {
        $model = new PasswordForm(Yii::$app->user->identity->id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionSetAvatar($id)
    {
        $form = new UserFotoForm();
        $post = Yii::$app->request->post();
        if($form->load($post) && $form->validate()){
            try {
                $this->user_service->setAvatar($id,$form->media_id);
                Yii::$app->session->setFlash('success', 'Фото установлено');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['cabinet/settings']);
    }
}