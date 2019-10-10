<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\modules\referenceBooks\models\Transport;
use backend\modules\referenceBooks\models\TransportSearch;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;

class TransportController extends Controller {

    /** @var $access Access*/
    private $access;

    public function __construct($id, Module $module,array $config = [])
    {
        parent::__construct($id, $module, $config);
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
            ]
        ];
    }

    /**
     * @perm('Просмотр транспортов (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new TransportSearch();
        $page = Yii::$app->user->identity->getSettings('transport')['count-page'][0]??10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание транспорта (справочник)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        if ($data = Yii::$app->request->post('Transport')) {
            $this->save($data);
        }
        $transport = new Transport();
        return $this->render('_form', [
                    'transport' => $transport
        ]);
    }

    /**
     * @perm('Редактирование транспорта (справочник)')
     */
    public function actionUpdate() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        $transport = Transport::findOne($id);
        if ($data = Yii::$app->request->post('Transport')) {
            $this->save($data, $id);
        }
        return $this->render('_form', [
                    'transport' => $transport
        ]);
    }

    /**
     * @perm('Удаление транспорта (справочник)')
     */
    public function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Transport::deleteAll(['id' => $id]);
        $this->redirect(['/referenceBooks/transport']);
    }

    /**
     * @perm('Смена статуса транспорта (справочник)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $transport = Transport::findOne($data['id']);
            $transport->$name = (bool) $data['value'];
            $transport->update(FALSE);
        }
    }

    public function actionUpdatePage() {
        
    }

    private function save($data, $id = NULL) {
        $transport = ($id === NULL) ? new Transport() : Transport::findOne($id);
        $transport->code = $data['code'];
        $transport->name = $data['name'];
        $transport->status = (isset($data['status'])) ? $data['status'] : FALSE;
        $transport->save();
        $this->redirect(['/referenceBooks/transport']);
    }

}
