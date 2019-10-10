<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\modules\referenceBooks\models\Entertainment;
use backend\modules\referenceBooks\models\EntertainmentSearch;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\City;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;

class EntertainmentController extends Controller {

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
     * @perm('Просмотр развлечений (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new EntertainmentSearch();
        $page = Yii::$app->user->identity->getSettings('entertainment')['count-page'][0]??10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание развлечения (справочник)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        if ($data = Yii::$app->request->post('Entertainment')) {
            $this->save($data);
        }
        $entertainment = new Entertainment();
        $country = Country::find()->select(['cid', 'name'])->where(['status' => 1])->asArray()->all();
        $country = ArrayHelper::map($country, 'cid', 'name');
        $city = City::find()->select(['cid', 'name'])->where(['status' => 1])->asArray()->all();
        $city = ArrayHelper::map($city, 'cid', 'name');
        return $this->render('_form', [
                    'entertainment' => $entertainment,
                    'country' => $country,
//                    'city' => $city
        ]);
    }

    /**
     * @perm('Редактирование развлечения (справочник)')
     */
    public function actionUpdate() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        $entertainment = Entertainment::findOne($id);
        $country = Country::find()->select(['cid', 'name'])->where(['status' => 1])->asArray()->all();
        $country = ArrayHelper::map($country, 'cid', 'name');
        $city = City::find()->select(['cid', 'name'])->where(['status' => 1])->asArray()->all();
        $city = ArrayHelper::map($city, 'cid', 'name');
        if ($data = Yii::$app->request->post('Entertainment')) {
            $this->save($data, $id);
        }
        return $this->render('_form', [
                    'entertainment' => $entertainment,
//                    'city' => $city,
                    'country' => $country
        ]);
    }

    /**
     * @perm('Удаление развлечения (справочник)')
     */
    public function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Entertainment::deleteAll(['id' => $id]);
        $this->redirect(['/referenceBooks/entertainment']);
    }

    /**
     * @perm('Смена статуса развлечения (справочник)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $entertainment = Entertainment::findOne($data['id']);
            $entertainment->$name = (bool) $data['value'];
            $entertainment->update(FALSE);
        }
    }

    public function actionUpdatePage() {
        
    }

    public function actionGetCity() {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $city = City::find()->select(['cid', 'name'])->asArray()->where(['country_id' => $id, 'status' => TRUE])->all();
            return Json::encode($city);
        }
    }

    private function save($data, $id = NULL) {
        $city = ($id === NULL) ? new Entertainment() : Entertainment::findOne($id);
        $city->country_id = $data['country_id'];
        $city->city_id = $data['city_id'];
        $city->media_id = $data['media_id'];
        $city->name = $data['name'];
        $city->description = $data['description'];
        $city->status = (isset($data['status'])) ? $data['status'] : FALSE;
        $city->save();
        $this->redirect(['/referenceBooks/entertainment']);
    }

}
