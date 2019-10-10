<?php

namespace backend\modules\user\controllers;

use backend\modules\user\forms\PassportForm;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\modules\user\helpers\Status;
use backend\modules\user\forms\UserForm;
use backend\modules\user\useCase\Access;
use backend\modules\user\services\RbacService;
use backend\modules\user\entities\IntPassport;
use backend\modules\user\services\UserService;
use backend\modules\user\forms\IntPassportForm;
use backend\modules\user\forms\search\UserSearch;
use backend\modules\user\services\PassportService;
use backend\modules\user\dispatchers\EventDispatcher;
use backend\modules\user\services\IntPassportService;

/**
 * Class UserController
 */
class UserController extends Controller
{
    private $user_service;
    private $passport_service;
    private $passport_int_service;
    private $dispatcher;

    /** $var $access Access */
    private $access;
    /**
     * @var RbacService
     */
    private $rbacService;

    public function __construct($id, Module $module,
                                UserService $user,
                                PassportService $passport,
                                IntPassportService $int_passport,
                                EventDispatcher $dispatcher,
                                RbacService $rbacService,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->user_service = $user;
        $this->passport_service = $passport;
        $this->passport_int_service = $int_passport;
        $this->dispatcher = $dispatcher;
        $this->access = new Access();
        $this->rbacService = $rbacService;
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
     * @perm('Просмотр всех пользователей (пользователи)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new UserSearch();
        $page = Yii::$app->user->identity->getSettings('user')['count-page'][0]??10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$page);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user_settings' => Yii::$app->user->identity->getSettings('user'),
            'page' => $page,
            'access' => $this->access,
            'roles' => $this->rbacService->getAllRole(['admin'])
        ]);
    }

    /**
     * @perm('Cоздание пользователя (пользователи)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $form = new UserForm();
        $form->setScenario(UserForm::CREATE_USER);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->user_service->create($form);
                Yii::$app->session->setFlash('success', 'Пользователь создан');
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
     * @perm('Просмотр пользователя (пользователи)')
     */
    public function actionView($id)
    {
        $this->access->accessAction();
        return $this->render('view', [
            'user' => $this->findModel($id),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Редактирование пользователя (пользователи)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $user = $this->findModel($id);

        $form = new UserForm($user);
        $form->setScenario(UserForm::EDIT_USER);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $userEdit = $this->user_service->edit($form,$user->id);
                $this->dispatcher->dispatchAll($userEdit->releaseEvents());
                Yii::$app->session->setFlash('success', 'Пользователь отредактирован');
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    /**
     * @perm('Редактирование загран паспорта (пользователи)')
     */
    public function actionUpdateInt($id,$user_id)
    {
        $this->access->accessAction();
        $passport = IntPassport::findOne($id);
        $form = new IntPassportForm($passport);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passport_int_service->edit($form,$passport->id);
                Yii::$app->session->setFlash('success', 'Загранпаспорт отредоктирован');
                return $this->redirect(['view','id' => $user_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
        return $this->render('update-int', [
            'model' => $form,
            'passport' => $passport,
        ]);
    }

    /**
     * @perm('Вкл./Выкл. верификация паспорта (пользователи)')
     */
    public function actionVerifyToggle()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try {
            $this->user_service->verifyToggle($post['status'],$post['name']);
            Yii::$app->session->setFlash('success', Status::getVerifyToggleInfo($post['status']));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @perm('Право верефицировать укр. паспорта (пользователи)')
     */
    public function actionVerify()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try {
            $passport = $this->passport_service->verify($post['passport_id'],$post['verify']);
            $this->dispatcher->dispatchAll($passport->releaseEvents());
            Yii::$app->session->setFlash('success', Status::getVerifyInfo($post['verify']));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @perm('Право верефицировать загран паспорта (пользователи)')
     */
    public function actionVerifyInt()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try {
            $this->passport_int_service->verify($post['passport_id'],$post['verify']);
            Yii::$app->session->setFlash('success', Status::getVerifyInfo($post['verify']));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @perm('Отклонение скан паспорта (пользователи)')
     */
    public function actionRejectScan()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try {
            if($post['passport_type'] == 'ukr'){
                $passport = $this->passport_service->rejectScan($post['passport_id']);
            } else {
                $passport = $this->passport_int_service->rejectScan($post['passport_id']);
            }
            $this->dispatcher->dispatchAll($passport->releaseEvents());
            Yii::$app->session->setFlash('success', 'Скан откланен');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @perm('Удаление пользователя (пользователи)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        try {
            $this->user_service->remove($id);
            Yii::$app->session->setFlash('success', 'Пользователь удален');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @perm('Удаление привязаных загран паспортов (пользователи)')
     */
    public function actionRemoveInt()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try {
            $this->passport_int_service->remove($post['passport_id']);
            Yii::$app->session->setFlash('success', 'Данные по паспорту были удалены');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id) : User
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}