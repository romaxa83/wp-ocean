<?php

namespace frontend\controllers\cabinet;

use frontend\controllers\BaseController;
use frontend\helpers\Dispatch;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\modules\user\services\UserService;
use backend\modules\user\forms\SmartMailingForm;
use backend\modules\user\services\SmartMailingService;

class DispatchController extends BaseController
{
    public $layout = 'cabinet';

    private $user_id;
    private $smart_service;
    private $user_service;

    public function __construct($id, Module $module,
                                SmartMailingService $smart_service,
                                UserService $user_service,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->user_id = Yii::$app->user->id;
        $this->smart_service = $smart_service;
        $this->user_service = $user_service;
    }

    public function beforeAction($action)
    {
        if ($action->id == 'check-dispatch') {
            \Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $form = new SmartMailingForm();

        if($form->load(Yii::$app->request->post()) && $form->validate()){
            try {
                $this->smart_service->create($form,$this->user_id);

                Yii::$app->session->setFlash('success', 'Подписка была создана,поиск начался,в случае успех вы получить письмо');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['cabinet/dispatch']);
    }

    public function actionRemove()
    {
        $post = Yii::$app->request->post();
        try {
            $this->smart_service->remove($post['id']);
            Yii::$app->session->setFlash('success', 'Подписка была успешно удалена.');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['cabinet/dispatch']);
    }

    public function actionCheckDispatch()
    {
        $post = Yii::$app->request->post();
        try {
            $this->user_service->dispatchToggle($post['user_id'],$post['check']);
            Yii::$app->session->setFlash('success', Dispatch::status($post['check']));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}