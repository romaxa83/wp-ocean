<?php

namespace backend\modules\dispatch\controllers;

use backend\modules\dispatch\useCase\UploadPattern;
use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\user\useCase\Access;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\dispatch\entities\Notifications;
use backend\modules\dispatch\forms\NotificationsForm;
use backend\modules\dispatch\services\NotificationsService;
use backend\modules\dispatch\forms\search\NotificationsSearch;

class NotificationsController extends Controller
{
    private $notifications_service;

    /** @var $access Access*/
    private $access;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function __construct($id, Module $module, NotificationsService $notification,array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->notifications_service = $notification;
        $this->access = new Access();
    }

    /**
     * @perm('Просмотр всех техн.уведомлений (рассылка)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new NotificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Редактирование техн.уведомлений (рассылка)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $notification = $this->findModel($id);
        $form = new NotificationsForm($notification);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->notifications_service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Шаблон письма отредактирован');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'notification' => $notification,
        ]);
    }

    /**
     * @perm('Смена статуса техн.уведомлений (рассылка)')
     */
    public function actionStatusChange()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->notifications_service->changeStatus($post['id'],$post['checked']);
            Yii::$app->session->setFlash('success',StatusHelper::infoFlashNotification($post['checked']));

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::toRoute('/dispatch/notifications/index'));
    }

    /**
     * @perm('Загрузка шаблонов для техн.уведомлений (рассылка)')
     */
    public function actionUploadPattern()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        if($post['status'] == 'upload'){
            $result = (new UploadPattern())->start();
            if($result){
                Yii::$app->session->setFlash(
                    'success',
                    'Было загружено ('. $result .') шаблонов.');
            } else {
                Yii::$app->session->setFlash(
                    'warning',
                    'Нет шаблонов для загрузки');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @perm('Удаление шаблонов для техн.уведомлений (рассылка)')
     */
    public function actionPatternDelete()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        if($post['status'] == 'pattern-delete'){
            $result = (new UploadPattern())->remove();
            Yii::$app->session->setFlash(
                'warning',
                $result);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id) : Notifications
    {
        if (($model = Notifications::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}