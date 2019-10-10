<?php

namespace backend\modules\user\controllers;

use backend\modules\user\helpers\RolesHelper;
use backend\modules\user\useCase\ParsePermission;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use backend\modules\user\useCase\Access;
use backend\modules\user\forms\rbac\RoleForm;
use backend\modules\user\services\RbacService;

class RbacController extends Controller
{
    /**
     * @var RbacService
     */
    private $rbacService;

    /** $var $access Access */
    private $access;

    public function __construct($id, Module $module,
                                RbacService $rbacService,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->rbacService = $rbacService;
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
     * @perm('Просмотр разрешений и ролей (пользователи)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();

        return $this->render('index',[
            'allRoles' => $this->rbacService->getAllRole(['user','admin']),
            'allPermissions' => $this->rbacService->getAllPermission(),
            'groupPermissions' => $this->rbacService->getGroupPermissions(),
            'checkPermissions' => [],
            'checkRole' => '',
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание роли (пользователи)')
     */
    public function actionCreateRole()
    {
        $this->access->accessAction();
        $form = new RoleForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $role = $this->rbacService->createRole($form);
                Yii::$app->session->setFlash(
                    'success',
                    'Роль '. $role->name .' ('. $role->description .') создана');
                return $this->redirect(['index']);

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-role', [
            'form' => $form,
            'allRoles' => $this->rbacService->getAllRole()
        ]);
    }

    /**
     * @perm('Прикрепление разрешения к роли (пользователи)')
     */
    public function actionAttachPermission()
    {
        $this->access->accessAction();
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            try {
                $this->rbacService->attachPermission($post['role'],$post['permissions'],$post['group']);

                return $this->renderPartial('_index_role',[
                    'allRoles' => $this->rbacService->getAllRole(['user','admin']),
                    'checkRole' => $post['role'],
                    'access' => $this->access
                ]);

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
    }

    /**
     * @perm('Удаление роли (пользователи)')
     */
    public function actionRemoveRole()
    {
        $this->access->accessAction();
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            try {
                $result = $this->rbacService->removeRole($post['role']);

                if(!$result){
                    return false;
                }

                return $this->renderPartial('_index_role',[
                    'allRoles' => $this->rbacService->getAllRole(['user','admin']),
                    'checkRole' => [],
                    'access' => $this->access
                ]);

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
    }

    public function actionRenderCheckPermission()
    {
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();

            return $this->renderPartial('_index_perm',[
                'allPermissions' => $this->rbacService->getAllPermission($post['groupName']),
                'checkPermissions' => $this->rbacService->getPermissionByRole($post['role']),
                'access' => $this->access
            ]);
        }
    }

    public function actionGetGroupPermissions()
    {
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();

            return $this->renderPartial('_index_perm',[
                'allPermissions' => $this->rbacService->getAllPermission($post['groupName']),
                'checkPermissions' => isset($post['role'])
                    ? $this->rbacService->getPermissionByRole($post['role'])
                    : [],
                'access' => $this->access
            ]);
        }
    }

    /**
     * @perm('Загрузка разрешений (пользователи)')
     */
    public function actionUploadPermissions()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        if($post['status'] == 'upload'){
            $result = (new ParsePermission())->start();
            if($result){
                Yii::$app->session->setFlash(
                    'success',
                    'Было загружено ('. $result .') разрешений.');
            } else {
                Yii::$app->session->setFlash(
                    'warning',
                    'Нет разрешений для загрузки');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionFreeRoles()
    {
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();

            $role = $this->rbacService->getAllRole(RolesHelper::getExistRoles($post['role']));

            if($role){
                return JSON::encode($role);
            }
            Yii::$app->session->setFlash(
                'warning',
                'Нет доступных ролей.');

            return $this->redirect(Url::toRoute(['/user/user/view','id' => $post['id']]));
        }
    }

    public function actionAttachRoles()
    {
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();

            if(!(RolesHelper::countRoles($post['role']) <= 1)){
                return JSON::encode($this->rbacService->getArrayRolesByStringNames($post['role']));
            }
            Yii::$app->session->setFlash(
                'danger',
                'Невозможно удалить роль.');

            return $this->redirect(Url::toRoute(['/user/user/view','id' => $post['id']]));
        }
    }

    /**
     * @perm('Добавить дополнительную роль (пользователи)')
     */
    public function actionAttachRoleForUser()
    {
        $this->access->accessAction();
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            try {
                $this->rbacService->assignmentRole($post['role'],$post['id']);

                Yii::$app->session->setFlash(
                    'success',
                    'К пользователю привязана дополнительная роль.');

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }

            return $this->redirect(Url::toRoute(['/user/user/view','id' => $post['id']]));
        }
    }

    /**
     * @perm('Удалить дополнительную роль (пользователи)')
     */
    public function actionDetachedRoleForUser()
    {
        $this->access->accessAction();
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            try {
                $this->rbacService->detachedRole($post['role'],$post['id']);

                Yii::$app->session->setFlash(
                    'success',
                    'Пользователю отвязана дополнительная роль.');

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }

            return $this->redirect(Url::toRoute(['/user/user/view','id' => $post['id']]));
        }
    }
}