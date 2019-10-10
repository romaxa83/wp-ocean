<?php

namespace backend\modules\dispatch\controllers;

use backend\modules\dispatch\entities\Statistic;
use backend\modules\dispatch\entities\Subscriber;
use backend\modules\dispatch\helpers\DateHelper;
use backend\modules\dispatch\repository\StatisticRepository;
use backend\modules\dispatch\services\StatisticService;
use backend\modules\staticBlocks\repository\StaticDataRepository;
use function PHPSTORM_META\type;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\user\useCase\Access;
use backend\modules\dispatch\entities\NewsLetter;
use backend\modules\dispatch\forms\NewsLetterForm;
use backend\modules\dispatch\services\NewsService;
use backend\modules\dispatch\forms\search\NewsLetterSearch;
use backend\modules\dispatch\repository\SubscriberRepository;

class NewsLetterController extends Controller
{
    private $news_service;
    private $subscriber_repository;

    /** @var $access Access*/
    private $access;
    /**
     * @var StatisticRepository
     */
    private $statisticRepository;

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
    
    public function __construct($id, Module $module,
                                NewsService $news,
                                SubscriberRepository $subs_rep,
                                StatisticRepository $statisticRepository,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->news_service = $news;
        $this->subscriber_repository = $subs_rep;
        $this->access = new Access();
        $this->statisticRepository = $statisticRepository;
    }

    /**
     * @perm('Просмотр новосных писем (рассылка)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new NewsLetterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание новосного письма (рассылка)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $form = new NewsLetterForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->news_service->create($form);
                Yii::$app->session->setFlash('success', 'Информационая рассылка создан');
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
     * @perm('Просмотр новосного письма (рассылка)')
     */
    public function actionView($id)
    {
        $this->access->accessAction();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Редактирование новосного письма (рассылка)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $news = $this->findModel($id);
        $form = new NewsLetterForm($news);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->news_service->edit($form,$id);
                Yii::$app->session->setFlash('success', 'Информационая рассылка отредактирован');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'news' => $news,
        ]);
    }

    /**
     * @perm('Удаление новосного письма (рассылка)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->news_service->remove($id);
            Yii::$app->session->setFlash('success', 'Информационая рассылка удалена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @perm('Выбор подписчиков для новосной рассылки (рассылка)')
     */
    public function actionChooseSubscribers()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try {
            $subscribers = $this->subscriber_repository->getAllActive();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::toRoute(['index']));
        }

        return $this->renderAjax('/subscriber/list-for-send',[
            'subscribers' => $subscribers,
            'letter_id' => $post['id']
        ]);
    }

    /**
     * @perm('Запуск рассылки (рассылка)')
     */
    public function actionSendEmails()
    {
        $this->access->accessAction();
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            $this->news_service->startDispatch($post['arr_subscribers'],$post['letter_id']);
        }
    }

    /**
     * запускает консольный скрипт для массовой рассылки в фоне
     */
    public function actionStartDispatch()
    {
        if(Yii::$app->request->isAjax){
            $letterId = Yii::$app->request->post('letter_id');

            Yii::$app->consoleRunner->run('dispatch-cron/start '.$letterId);

            return $this->renderAjax('_progress-bar',[
                'data' => $this->statisticRepository->getByLetterId($letterId)
            ]);
        }
    }

    /**
     * скрипт проверяет процесс рассылки
     */
    public function actionProgressDispatch()
    {
        if(Yii::$app->request->isAjax){
            $letterId = Yii::$app->request->post('letter_id');

            $statistic = Statistic::find()->where(['letter_id' => $letterId])->one();

            if($statistic->end_time == null){
                return $this->renderAjax('_progress-bar',[
                    'data' => $this->statisticRepository->getByLetterId($letterId)
                ]);
            }
            return false;
        }
    }

    protected function findModel($id) : NewsLetter
    {
        if (($model = NewsLetter::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}