<?php

namespace backend\modules\faq\controllers;

use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\faq\models\Faq;
use backend\modules\user\useCase\Access;
use backend\modules\faq\models\FaqSearch;
use backend\modules\faq\services\FaqService;
use backend\modules\blog\helpers\StatusHelper;

class FaqController extends Controller
{
    private $faq_service;

    /** $var $access Access */
    private $access;

    public function __construct($id, Module $module,FaqService $faq_service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->faq_service = $faq_service;
        $this->access = new Access();
    }

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ]
        ];
    }

    /**
     * @perm('Просмотр всех F.A.Q (faq)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new FaqSearch();
        $page = Yii::$app->user->identity->getSettings('faq')['count-page'][0]??10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_settings' => Yii::$app->user->identity->getSettings('faq'),
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание F.A.Q (faq)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $form = new Faq();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->faq_service->save($form);
                Yii::$app->session->setFlash('success', 'Запись создана');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Просмотр F.A.Q (faq)')
     */
    public function actionView($id)
    {
        $this->access->accessAction();
        return $this->render('view', [
            'faq' => $this->findModel($id),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Редактирование F.A.Q (faq)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $this->faq_service->update($model);
                Yii::$app->session->setFlash('success', 'Запись отредоктирована');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $model,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Смена статуса F.A.Q (faq)')
     */
    public function actionStatusChange($alias = null)
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $result = $this->faq_service->changeStatus($post,$alias);
            if($result){
                Yii::$app->session->setFlash('success',StatusHelper::infoFlashFaq($post['checked'],$alias));
            } else {
                Yii::$app->session->setFlash('warning','Нельзя опубликовать вопрос на странице ,так как вопрос не активен.');
            }

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::toRoute('/faq/faq/index'));
    }

    /**
     * @perm('Изменение рейтинга F.A.Q (faq)')
     */
    public function actionChangeRate()
    {
        $this->access->accessAction();
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            try{
                $this->faq_service->changeRate($post);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
            }
        }
    }

    /**
     * @perm('Удаление F.A.Q (faq)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->faq_service->remove($id);
            Yii::$app->session->setFlash('success', 'Запись удалена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id) : Faq
    {
        if (($model = Faq::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
