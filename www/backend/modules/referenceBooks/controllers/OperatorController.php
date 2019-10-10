<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\modules\referenceBooks\models\Operator;
use backend\modules\referenceBooks\models\OperatorSearch;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class OperatorController extends Controller {

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
     * @perm('Просмотр операторов (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new OperatorSearch();
        $page = Yii::$app->user->identity->getSettings('operator')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Смена статуса оператора (справочник)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $city = Operator::findOne($data['id']);
            $city->$name = (bool) $data['value'];
            $city->update(FALSE);
        }
    }

}
