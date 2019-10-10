<?php

namespace backend\modules\faq\controllers;

use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\user\useCase\Access;
use backend\modules\faq\models\Category;
use backend\modules\faq\services\FaqService;
use backend\modules\faq\models\CategorySearch;
use backend\modules\blog\helpers\StatusHelper;

class CategoryController extends Controller
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
     * @perm('Просмотр всех категорий для F.A.Q (faq)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание категории для F.A.Q (faq)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $form = new Category();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {
                $this->faq_service->saveCategory($form);
                Yii::$app->session->setFlash('success', 'Категория для F.A.Q. создана');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @perm('Редактирование категории для F.A.Q (faq)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $this->faq_service->updateCategory($model);
                Yii::$app->session->setFlash('success', 'Категория для F.A.Q. отредоктирована');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @perm('Смена статуса категории для F.A.Q (faq)')
     */
    public function actionStatusChange($alias = null)
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->faq_service->changeStatusCategory($post);
            Yii::$app->session->setFlash('success',StatusHelper::infoFlash($post['checked'],'Категория'));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::toRoute('/faq/category/index'));
    }

    /**
     * @perm('Удаление категории для F.A.Q (faq)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $result = $this->faq_service->removeCategory($id);
            if(array_key_exists('error',$result)){
                Yii::$app->session->setFlash('warning', $result['error']);
            } else {
                Yii::$app->session->setFlash('success', 'Категория удалена.');
            }
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::toRoute(['index']));
    }

    /**
     * @perm('Перемещение категории вверх (faq)')
     */
    public function actionMoveUp($id)
    {
        $this->access->accessAction();
        $this->faq_service->moveUp($this->findModel($id));
        return $this->redirect(Url::toRoute(['index']));
    }

    /**
     * @perm('Перемещение категории вниз (faq)')
     */
    public function actionMoveDown($id)
    {
        $this->access->accessAction();
        $this->faq_service->moveDown($this->findModel($id));
        return $this->redirect(Url::toRoute(['index']));
    }

    protected function findModel($id) : Category
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
