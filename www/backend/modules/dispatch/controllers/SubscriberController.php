<?php

namespace backend\modules\dispatch\controllers;

use backend\modules\blog\helpers\StatusHelper;
use backend\modules\dispatch\forms\search\SubscriberSearch;
use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\dispatch\entities\Subscriber;
use backend\modules\dispatch\services\SubscriberService;
use backend\modules\dispatch\forms\search\NotificationsSearch;
use yii\filters\AccessControl;

class SubscriberController extends Controller
{
    private $subscriber_service;

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
    
    public function __construct($id, Module $module, SubscriberService $subscriber,array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->subscriber_service = $subscriber;
        $this->access = new Access();
    }

    /**
     * @perm('Просмотр подписчиков для рассылки (рассылка)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new SubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Смена статуса подписчика для рассылки (рассылка)')
     */
    public function actionStatusChange()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->subscriber_service->changeStatus($post['id'],$post['checked']);
            Yii::$app->session->setFlash('success',StatusHelper::infoFlashSubscriber($post['checked']));

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::toRoute('/dispatch/subscriber/index'));
    }

    /**
     * @perm('Удаление подписчика для рассылки (рассылка)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->subscriber_service->remove($id);
            Yii::$app->session->setFlash('success', 'Подписчик удален');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id) : Subscriber
    {
        if (($model = Subscriber::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}