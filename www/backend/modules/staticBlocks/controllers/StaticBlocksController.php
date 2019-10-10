<?php

namespace backend\modules\staticBlocks\controllers;

use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\user\useCase\Access;
use backend\modules\staticBlocks\type\StatusType;
use backend\modules\staticBlocks\helpers\InfoFlash;
use backend\modules\staticBlocks\services\StaticBlocksService;
use backend\modules\staticBlocks\repository\StaticDataRepository;

class StaticBlocksController extends Controller
{
    protected $static_service;

    protected $static_repository;

    /** $var $access Access */
    protected $access;

    public function __construct($id, Module $module,
                                StaticBlocksService $static,
                                StaticDataRepository $static_rep,
                                array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->static_service = $static;
        $this->static_repository = $static_rep;
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
     * @perm('Вкл./Выкл. блок (блоки на гл.)')
     */
    public function actionToggleBlock()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->static_service->toggleBlock($post['block'],$post['status_block']);
            Yii::$app->session->setFlash('success',InfoFlash::block($post['status_block'],$post['block']));

        } catch (\DomainException $e) {
            $this->error($e);
        }
        return $this->redirect(Url::toRoute('/staticBlocks/'. $post['block'] .'/index'));
    }

    /**
     * @perm('Вкл./Выкл. элементов в блоке (блоки на гл.)')
     */
    public function actionToggleStatus()
    {
        $this->access->accessAction();
        $post = Yii::$app->request->post();
        try{
            $this->static_service->changeStatus(new StatusType($post['id'],$post['checked']));
            Yii::$app->session->setFlash('success',InfoFlash::sectionBlock($post['checked'],$post['block']));

        } catch (\DomainException $e) {
            $this->error($e);
        }
        return $this->redirect(Url::toRoute('/staticBlocks/'. $post['block'] .'/index'));
    }

    protected function error(\DomainException $e)
    {
        Yii::$app->errorHandler->logException($e);
        Yii::$app->session->setFlash('error', $e->getMessage());
    }
}
