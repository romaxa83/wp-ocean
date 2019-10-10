<?php

namespace backend\modules\user\controllers;

use Yii;
use yii\helpers\Url;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\user\useCase\Access;
use backend\modules\user\helpers\Status;
use backend\modules\user\entities\Reviews;
use backend\modules\user\forms\ReviewsEditForm;
use backend\modules\user\services\ReviewsService;
use backend\modules\user\forms\search\ReviewsSearch;

class ReviewsController extends Controller
{
    private $reviews_service;

    /** $var $access Access */
    private $access;

    public function __construct($id, Module $module,
                                ReviewsService $reviews,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->reviews_service = $reviews;
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
     * @perm('Просмотр всех отзывов пользователей (пользователи)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new ReviewsSearch();
        $page = Yii::$app->user->identity->getSettings('reviews')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_settings' => Yii::$app->user->identity->getSettings('reviews'),
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Редактирование отзыва пользователя (пользователи)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $reviews = $this->findModel($id);

        $form = new ReviewsEditForm($reviews);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->reviews_service->edit($form,$reviews->id);
                Yii::$app->session->setFlash('success', 'Отзыв отредоктирован');

                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * @perm('Изменение статуса отзыва пользователя (пользователи)')
     */
    public function actionStatusChange()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try {
            $this->reviews_service->changeStatus($post['id'], $post['checked']);
            Yii::$app->session->setFlash('success', Status::getReviewsToggleInfo($post['checked']));

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(Url::toRoute('/user/reviews/index'));
    }

    /**
     * @perm('Удаление отзыва пользователя (пользователи)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->reviews_service->remove($id);
            Yii::$app->session->setFlash('success', 'Отзыв удален');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id) : Reviews
    {
        if (($model = Reviews::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}