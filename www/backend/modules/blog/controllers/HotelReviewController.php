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
use backend\modules\blog\type\MessageType;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\entities\HotelReview;
use backend\modules\blog\forms\HotelReviewForm;
use backend\modules\blog\services\HotelReviewService;
use backend\modules\blog\forms\search\HotelReviewSearch;
use backend\modules\blog\repository\HotelReviewRepository;

class HotelReviewController extends Controller
{
    /**
     * @var HotelReviewService
     */
    private $hotelReviewService;
    /**
     * @var HotelReviewRepository
     */
    private $hotelReviewRepository;

    /**
     * @var $access Access
     */
    private $access;

    public function __construct($id, Module $module,
                                HotelReviewService $hotelReviewService,
                                HotelReviewRepository $hotelReviewRepository,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->hotelReviewService = $hotelReviewService;
        $this->hotelReviewRepository = $hotelReviewRepository;
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
     * @perm('Просмотр всех обзоров (блог)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new HotelReviewSearch();
        $page = Yii::$app->user->identity->getSettings('post_hotel_review')['count-page'][0]??10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$page);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_settings' => Yii::$app->user->identity->getSettings('post_hotel_review'),
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Просмотр обзора (блог)')
     */
    public function actionView($id)
    {
        $this->access->accessAction();
        return $this->render('view', [
            'hotelReview' => $this->hotelReviewRepository->getWithSeo($id),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание обзора (блог)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $form = new HotelReviewForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->hotelReviewService->create($form);
                Yii::$app->session->setFlash('success', 'Обзор на отель создан');
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
     * @perm('Редактирование обзора (блог)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $hotelReview = $this->hotelReviewRepository->getWithSeo($id);

        $form = new HotelReviewForm($hotelReview);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->hotelReviewService->edit($hotelReview->id, $form);
                Yii::$app->session->setFlash('success', 'Обзор на отель отредактирован');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'post' => $hotelReview,
        ]);
    }

    /**
     * @perm('Смена статус обзора (блог)')
     */
    public function actionStatusChange()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->hotelReviewService->changeStatus($post['id'],$post['checked']);
            Yii::$app->session->setFlash('success',StatusHelper::infoFlash($post['checked'],'Обзор'));

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::toRoute('/blog/hotel-review/index'));
    }

    /**
     * @perm('Добавление картинки в галерею к обзору (блог)')
     */
    public function actionAddImgToGallery()
    {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            try{
                $message = $this->hotelReviewService->addImgToGallery($post);
                $this->setFlash($message);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect($post['url']);
        }
    }

    /**
     * @perm('Удаление картинки из галерею к обзору (блог)')
     */
    public function actionRemoveImg()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->hotelReviewService->removeMediaId($post);
            Yii::$app->session->setFlash('success','Фото удаленно');

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Url::toRoute(['view','id' => $post['hotel_review_id']]));
    }

    /**
     * @perm('Удаление обзора (блог)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->hotelReviewService->remove($id);
            Yii::$app->session->setFlash('success', 'Обзор на отель удален');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    protected function findModel($id) : HotelReview
    {
        if (($model = HotelReview::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function setFlash(MessageType $message)
    {
        if($message->getType() == 'error'){
            Yii::$app->session->setFlash('danger',$message->getMessage());
        } else {
            Yii::$app->session->setFlash('success',$message->getMessage());
        }
    }
}
