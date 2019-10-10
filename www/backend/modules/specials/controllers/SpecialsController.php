<?php

namespace backend\modules\specials\controllers;

use backend\modules\specials\models\SpecialsSearch;
use Yii;
use backend\modules\user\useCase\Access;
use backend\modules\specials\models\Special;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;


class SpecialsController extends Controller {

    /** @var $access Access */
    private $access;

    public function __construct($id, Module $module, array $config = []) {
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
     * @perm('Просмотр акций (акции)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new SpecialsSearch();
        $page = Yii::$app->user->identity->getSettings('special')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }


    /**
     * @perm('Создание акции (акции)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        if ($data = Yii::$app->request->post('Special')) {
            $this->save($data);
        }
        $special = new Special();
        return $this->render('_form', [
            'special' => $special
        ]);
    }

    /**
     * @perm('Редактирование акции (акции)')
     */
    public function actionUpdate() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        $special = Special::findOne($id);
        if ($data = Yii::$app->request->post('Special')) {
            $this->save($data, $id);
        }
        return $this->render('_form', [
            'special' => $special
        ]);
    }


    /**
     * @perm('Удаление акции (акции)')
     */
    public function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Special::deleteAll(['id' => $id]);
        $this->redirect(['/specials/specials']);
    }

    /**
     * @perm('Смена статуса акции (акции)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $special = Special::findOne($data['id']);
            $special->$name = (bool)$data['value'];
            $special->update(FALSE);
        }
    }

    private function save($data, $id = NULL) {
        $special = ($id === NULL) ? new Special() : Special::findOne($id);

        $special->name = $data['name'];
        $special->from_datetime = date('Y-m-d H:i:s', strtotime($data['from_datetime']));
        $special->to_datetime = date('Y-m-d H:i:s', strtotime($data['to_datetime']));
        $special->status = (isset($data['status'])) ? $data['status'] : FALSE;

        if ($special->validate()) {
            $special->save();
        }

        $this->redirect(['/specials/specials']);
    }
}