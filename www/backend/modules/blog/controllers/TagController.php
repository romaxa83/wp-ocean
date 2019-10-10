<?php

namespace backend\modules\blog\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\blog\entities\Tag;
use backend\modules\blog\forms\TagForm;
use backend\modules\user\useCase\Access;
use backend\modules\blog\services\TagService;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\forms\search\TagSearch;

class TagController extends Controller
{
    /**
     * @var TagService
     */
    private $tag_service;

    /**
     * @var $access Access
     */
    private $access;

    public function __construct($id, $module, TagService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->tag_service = $service;
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
     * @perm('Просмотр тегов (блог)')
     * @return mixed
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Просмотр тега (блог)')
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->access->accessAction();
        return $this->render('view', [
            'tag' => $this->findModel($id),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание тега (блог)')
     * @return mixed
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $form = new TagForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->tag_service->create($form);
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
     * @perm('Редактирование тега (блог)')
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $tag = $this->findModel($id);
        $form = new TagForm($tag);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->tag_service->edit($tag->id, $form);

                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'tag' => $tag,
        ]);
    }

    /**
     * @perm('Смена статуса тега (блог)')
     */
    public function actionStatusChange()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->tag_service->changeStatus($post['id'],$post['checked']);
            Yii::$app->session->setFlash('success',StatusHelper::infoFlash($post['checked'],'Тег'));

            return $this->redirect(Url::toRoute('/blog/tag/index'));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @perm('Удаление тега (блог)')
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->tag_service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
    /**
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Tag
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}