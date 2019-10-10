<?php

namespace backend\modules\blog\controllers;

use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\user\useCase\Access;
use backend\modules\blog\entities\Category;
use backend\modules\blog\forms\CategoryForm;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\services\CategoryService;
use backend\modules\blog\forms\search\CategorySearch;

class CategoryController extends Controller
{
    private $category_service;

    /**
     * @var $access Access
     */
    private $access;

    public function __construct($id, Module $module,CategoryService $category_service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->category_service = $category_service;
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
            ],
        ];
    }

    /**
     * @perm('Просмотр всех категорий (блог)')
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
     * @perm('Просмотр категории (блог)')
     */
    public function actionView($id)
    {
        $this->access->accessAction();
        return $this->render('view', [
            'category' => $this->findModel($id),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Cоздание категории (блог)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();

        $form = new CategoryForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            try {
                $this->category_service->create($form);

                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }
    /**
     * @perm('Редактирование категории (блог)')
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $category = $this->findModel($id);
        $form = new CategoryForm($category);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->category_service->edit($category->id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    /**
     * @perm('Изменения статуса категории (блог)')
     */
    public function actionStatusChange()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->category_service->changeStatus($post['id'],$post['checked']);
            Yii::$app->session->setFlash('success',StatusHelper::infoFlash($post['checked'],'Категория'));

            return $this->redirect(Url::toRoute('/blog/category/index'));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
    /**
     * @perm('Удаление категории (блог)')
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->category_service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @perm('Перемещение категории вверх (блог)')
     */
    public function actionMoveUp($id)
    {
        $this->access->accessAction();
        $this->category_service->moveUp($id);
        return $this->redirect(['index']);
    }

    /**
     * @perm('Перемещение категории вниз (блог)')
     */
    public function actionMoveDown($id)
    {
        $this->access->accessAction();
        $this->category_service->moveDown($id);
        return $this->redirect(['index']);
    }

    protected function findModel($id) : Category
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
