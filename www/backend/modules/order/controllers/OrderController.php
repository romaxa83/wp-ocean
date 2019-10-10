<?php

namespace backend\modules\order\controllers;

use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\modules\user\useCase\Access;
use backend\modules\order\models\Order;
use backend\modules\order\models\OrderSearch;

class OrderController extends Controller
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
     * @perm('Просмотр заказов (заказы)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new OrderSearch();
        $page = Yii::$app->user->identity->getSettings('order')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Удаление заказа (заказы)')
     */
    function actionDelete($id) {
        $this->access->accessAction();
        Order::updateAll(['status' => 0], ['id' => $id]);
        $this->redirect(Url::toRoute(['/order/order'], TRUE));
    }

    /**
     * @perm('Закрытие заказа (заказы)')
     */
    function actionClose() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Order::updateAll(['status' => 2], ['id' => $id]);
        $order = Order::find()->where(['id' => $id])->asArray()->one();
        if (isset($order['ga_key'])) {
            $ga_order = Yii::$app->ga->request();
            $ga_order->setClientId($order['ga_key']);
            $ga_order->setUserId(1);
            $ga_order->setTransactionId($order['id']);
            $ga_order->addProduct([
                'name' => $order['name'],
                'coupon_code' => 'TEST',
            ]);
            $ga_order->setProductActionToPurchase();
            $ga_order->setEventCategory('Checkout')->setEventAction('Purchase')->sendEvent();
        }
        $this->redirect(Url::toRoute(['/order/order'], TRUE));
    }

    /**
     * @perm('Просмотр детальной информации заказа (заказы)')
     */
    public function actionInfo($id)
    {
        $this->access->accessAction();
        if(Yii::$app->request->isAjax){
            $order = Order::find()->select('info')->where(['id' => $id])->one();
            if($order->info){

                return $this->renderAjax('_more-info',[
                    'data' => json_decode($order->info)
                ]);
            }

            return $this->renderAjax('_more-info',[
                'data' => []
            ]);
        }
    }

}
