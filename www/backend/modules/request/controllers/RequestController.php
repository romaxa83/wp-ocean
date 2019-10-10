<?php

namespace backend\modules\request\controllers;

use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\modules\user\useCase\Access;
use backend\modules\request\models\Request;
use backend\modules\request\models\RequestSearch;

class RequestController extends Controller
{
    /** $var $access Access */
    private $access;

    public function __construct($id, Module $module,
                                array $config = [])
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
     * @perm('Просмотр заявок (заявки)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new RequestSearch();
        $page = Yii::$app->user->identity->getSettings('request')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Удаление заявки (заявки)')
     */
    function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Request::updateAll(['status' => 0], ['id' => $id]);
        $this->redirect(Url::toRoute(['/request/request'], TRUE));
    }

    /**
     * @perm('Закрытие заявки (заявки)')
     */
    function actionClose() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Request::updateAll(['status' => 2], ['id' => $id]);
        $request = Request::find()->where(['id' => $id])->asArray()->one();
        if (isset($request['ga_key'])) {
            $ga_request = Yii::$app->ga->request();
            $ga_request->setClientId($request['ga_key']);
            $ga_request->setUserId(1);
            $ga_request->setTransactionId($request['id']);
            $ga_request->addProduct([
                'name' => $request['name'],
                'coupon_code' => 'TEST',
            ]);
            $ga_request->setProductActionToPurchase();
            $ga_request->setEventCategory('Checkout')->setEventAction('Purchase')->sendEvent();
        }
        $this->redirect(Url::toRoute(['/request/request'], TRUE));
    }

}
