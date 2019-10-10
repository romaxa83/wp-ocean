<?php

namespace backend\modules\referenceBooks\controllers;

use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\user\useCase\Access;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\CitySearch;

class CityController extends Controller {

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
     * @perm('Просмотр городов (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new CitySearch();
        $page = Yii::$app->user->identity->getSettings('city')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание города (справочник)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        if ($data = Yii::$app->request->post('City')) {
            $this->save($data);
        }
        $city = new City();
        $country = Country::find()->select(['cid', 'name'])->where(['status' => 1])->asArray()->all();
        $country = ArrayHelper::map($country, 'cid', 'name');
        return $this->render('_form', [
            'city' => $city,
            'country' => $country
        ]);
    }

    /**
     * @perm('Редактирование города (справочник)')
     */
    public function actionUpdate() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        $city = City::findOne($id);
        $country = Country::find()->select(['cid', 'name'])->where(['status' => 1])->asArray()->all();
        $country = ArrayHelper::map($country, 'cid', 'name');
        if ($data = Yii::$app->request->post('City')) {
            $this->save($data, $id);
        }
        return $this->render('_form', [
                    'city' => $city,
                    'country' => $country
        ]);
    }

    /**
     * @perm('Удаление города (справочник)')
     */
    public function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        City::deleteAll(['id' => $id]);
        $this->redirect(['/referenceBooks/city']);
    }

    /**
     * @perm('Изменения статусов города (справочник)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $city = City::findOne($data['id']);
            $city->$name = (bool) $data['value'];
            $city->update(FALSE);
        }
    }

    public function actionUpdatePage() {
        if (Yii::$app->request->isAjax) {
            $page = (int) Yii::$app->request->post('page');
            $min = 0;
            $max = 100;
            $page = ($page < $min) ? $min : $page;
            $page = ($page > $max) ? $max : $page;
            $settings = Settings::find()->where(['name' => 'CityPage'])->one();
            if ($settings === NULL)
                $settings = new Settings();
            $settings->name = 'CityPage';
            $settings->body = $page;
            $settings->save();
            $this->redirect(['/referenceBooks/city']);
        }
    }

    public function actionUpdatePosition() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('item');
            foreach ($data as $k => $v) {
                City::updateAll(['position' => $k], ['=', 'cid', $v]);
            }
        }
    }

    private function save($data, $id = NULL) {
        if ($id === NULL) {
            $cid = City::find()->select(['id'])->orderBy(['id' => SORT_DESC])->limit(1)->asArray()->one();
            $data['cid'] = (int) '9' . $cid['id'];
        }
        $city = ($id === NULL) ? new City() : City::findOne($id);
        $city->country_id = $data['country_id'];
        $city->cid = (isset($data['cid'])) ? $data['cid'] : NULL;
        $city->code = $data['code'];
        $city->name = $data['name'];
        $city->alias = $data['code'];
        $city->description = $data['description'];
        $city->lat = $data['lat'];
        $city->lng = $data['lng'];
        $city->zoom = $data['zoom'];
        $city->capital = (isset($data['capital'])) ? $data['capital'] : FALSE;
        $city->status = (isset($data['status'])) ? $data['status'] : FALSE;
        $city->sync = (isset($data['sync'])) ? $data['sync'] : FALSE;
        $city->save();
        $this->redirect(['/referenceBooks/city']);
    }

}
