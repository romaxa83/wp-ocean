<?php

namespace backend\modules\filter\controllers;

use DateTime;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use backend\modules\filter\models\FilterSearch;
use backend\modules\filter\models\Filter;
use yii\filters\AccessControl;
use backend\modules\referenceBooks\models\Country;
use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\DeptCity;
use yii\data\ArrayDataProvider;
use backend\modules\referenceBooks\models\Category;
use backend\modules\referenceBooks\models\TypeFood;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\Hotel;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;

class FilterController extends Controller {

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

    public function actionIndex() {
        $searchModel = new FilterSearch();
        $page = Yii::$app->user->identity->getSettings('filter')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'page' => $page
        ]);
    }

    public function actionDelete() {
        Filter::deleteAll(['id' => Yii::$app->request->get('id')]);
        $this->redirect(Url::toRoute(['/filter/filter'], TRUE));
    }

    public function actionRenderLink() {
        if (Yii::$app->request->isAjax) {
            $link = '';
            $data = Yii::$app->request->post();
            if (isset($data['country']) && !empty($data['country']) && isset($data['dept_city']) && !empty($data['dept_city'])) {
                $country = Country::find()->select(['alias'])->where(['id' => $data['country']])->asArray()->one();
                $link = $country['alias'];
                $dept_city = DeptCity::find()->select(['alias'])->where(['id' => $data['dept_city']])->asArray()->one();
                $link .= '-' . $dept_city['alias'];
                if (isset($data['city']) && ((int) $data['city'] != 0)) {
                    $city = City::find()->select(['alias'])->where(['id' => $data['city']])->asArray()->one();
                    $link .= '/' . $city['alias'];
                }
            }
            return $link;
        }
    }

    public function actionCreate() {
        $countryList = [];
        $filter = new Filter();

        if (Yii::$app->request->isAjax && $filter->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($filter);
        }

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $this->save($data);
        }
        $dataProviderCountry = new ActiveDataProvider([
            'query' => Country::find()->where(['status' => TRUE]),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $dataProviderDeptCity = new ActiveDataProvider([
            'query' => DeptCity::find()->where(['status' => TRUE]),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $days = [];
        for ($i = 2; $i <= 26; $i++) {
            $days[] = [
                'id' => $i,
                'value' => $i . ' - ' . (($i == 26) ? 26 : ($i + 1)) . ' дней'
            ];
        }
        $dataProviderCategory = new ActiveDataProvider([
            'query' => Category::find()->where(['status' => TRUE]),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $dataProviderTypeFood = new ActiveDataProvider([
            'query' => TypeFood::find()->where(['status' => TRUE]),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $countryList = Country::find()->where(['status' => TRUE])->asArray()->all();
        $countryList = ArrayHelper::map($countryList, 'cid', 'name');
        $dataProviderCity = new ArrayDataProvider([
            'allModels' => [],
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
        $dataProviderHotel = new ArrayDataProvider([
            'allModels' => [],
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
        return $this->render('_form', [
                    'filter' => $filter,
                    'dataProviderCountry' => $dataProviderCountry,
                    'dataProviderDeptCity' => $dataProviderDeptCity,
                    'dataProviderCategory' => $dataProviderCategory,
                    'dataProviderTypeFood' => $dataProviderTypeFood,
                    'countryList' => $countryList,
                    'dataProviderCity' => $dataProviderCity,
                    'dataProviderHotel' => $dataProviderHotel
        ]);
    }

    public function actionUpdate() {
        $id = Yii::$app->request->get('id');
        $filter = Filter::findOne($id);

        if (Yii::$app->request->isAjax && $filter->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($filter);
        }

        $filter->country = unserialize($filter->country);
        $filter->dept_city = unserialize($filter->dept_city);
        $filter->date = unserialize($filter->date);
        $filter->length = unserialize($filter->length);
        $filter->people = unserialize($filter->people);
        $filter->category = unserialize($filter->category);
        $filter->food = unserialize($filter->food);
        $filter->price = unserialize($filter->price);
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $this->save($data, $id);
        }
        $countryEnable = [];
        $countryDisable = [];
        $counrty = ArrayHelper::index(Country::find()->where(['status' => TRUE])->asArray()->all(), 'id');
        foreach ($filter->country['country'] as $v) {
            if (isset($counrty[$v])) {
                $countryEnable[] = $counrty[$v];
            }
        }
        foreach ($counrty as $k => $v) {
            if (array_search($k, $filter->country['country']) === FALSE) {
                $countryDisable[] = $v;
            }
        }
        $dataProviderCountry = new ArrayDataProvider([
            'allModels' => array_merge($countryEnable, $countryDisable),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $deptCityEnable = [];
        $deptCityDisable = [];
        $deptCity = ArrayHelper::index(DeptCity::find()->where(['status' => TRUE])->asArray()->all(), 'id');
        foreach ($filter->dept_city['dept_city'] as $v) {
            if (isset($deptCity[$v])) {
                $deptCityEnable[] = $deptCity[$v];
            }
        }
        foreach ($deptCity as $k => $v) {
            if (array_search($k, $filter->dept_city['dept_city']) === FALSE) {
                $deptCityDisable[] = $v;
            }
        }
        $dataProviderDeptCity = new ArrayDataProvider([
            'allModels' => array_merge($deptCityEnable, $deptCityDisable),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $categoryEnable = [];
        $categoryDisable = [];
        $category = ArrayHelper::index(Category::find()->where(['status' => TRUE])->asArray()->all(), 'id');
        foreach ($filter->category['category'] as $v) {
            if (isset($category[$v])) {
                $categoryEnable[] = $category[$v];
            }
        }
        foreach ($category as $k => $v) {
            if (array_search($k, $filter->category['category']) === FALSE) {
                $categoryDisable[] = $v;
            }
        }
        $dataProviderCategory = new ArrayDataProvider([
            'allModels' => array_merge($categoryEnable, $categoryDisable),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $typeFoodEnable = [];
        $typeFoodDisable = [];
        $typeFood = ArrayHelper::index(TypeFood::find()->where(['status' => TRUE])->asArray()->all(), 'id');
        foreach ($filter->food['food'] as $v) {
            if (isset($typeFood[$v])) {
                $typeFoodEnable[] = $typeFood[$v];
            }
        }
        foreach ($typeFood as $k => $v) {
            if (array_search($k, $filter->food['food']) === FALSE) {
                $typeFoodDisable[] = $v;
            }
        }
        $dataProviderTypeFood = new ArrayDataProvider([
            'allModels' => array_merge($typeFoodEnable, $typeFoodDisable),
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);
        $countryList = Country::find()->where(['status' => TRUE])->asArray()->all();
        $countryList = ArrayHelper::map($countryList, 'cid', 'name');
        $dataProviderCity = new ArrayDataProvider([
            'allModels' => [],
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
        $dataProviderHotel = new ArrayDataProvider([
            'allModels' => [],
            'sort' => FALSE,
            'pagination' => [
                'pageSize' => 0,
            ],
        ]);
        return $this->render('_form', [
                    'filter' => $filter,
                    'dataProviderCountry' => $dataProviderCountry,
                    'dataProviderDeptCity' => $dataProviderDeptCity,
                    'dataProviderCategory' => $dataProviderCategory,
                    'dataProviderTypeFood' => $dataProviderTypeFood,
                    'countryList' => $countryList,
                    'dataProviderCity' => $dataProviderCity,
                    'dataProviderHotel' => $dataProviderHotel
        ]);
    }

    public function actionGetDateTo() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $date = isset($data['from']) ? DateTime::createFromFormat('d.m.Y', $data['from']) : date('d.m.Y');
            $from = $date->format('d.m.Y');
            return date('d.m.Y', strtotime($from . ' + ' . (int) $data['day'] . ' days'));
        }
    }

    public function actionGetDataCity() {
        if (Yii::$app->request->isAjax) {
            $cityEnable = [];
            $cityDisable = [];
            $data = Yii::$app->request->post();
            $city = ArrayHelper::index(City::find()->where(['country_id' => $data['country_id'], 'status' => TRUE])->asArray()->all(), 'id');
            if (isset($data['city']['city']) && count($data['city']['city']) > 0) {
                foreach ($data['city']['city'] as $v) {
                    $cityEnable[] = $city[$v];
                }
                foreach ($city as $k => $v) {
                    if (array_search($k, $data['city']['city']) === FALSE) {
                        $cityDisable[] = $v;
                    }
                }
            } else {
                $cityDisable = $city;
            }
            return $this->renderPartial('_item_data_city', [
                        'data' => $data,
                        'city' => array_merge($cityEnable, $cityDisable)
            ]);
        }
    }

    public function actionGetDataHotel() {
        if (Yii::$app->request->isAjax) {
            $hotelEnable = [];
            $hotelDisable = [];
            $data = Yii::$app->request->post();
            $hotel = ArrayHelper::index(Hotel::find()->where(['city_id' => $data['city_id'], 'status' => TRUE])->asArray()->all(), 'id');
            if (isset($data['hotel']['hotel']) && count($data['hotel']['hotel']) > 0) {
                foreach ($data['hotel']['hotel'] as $v) {
                    $hotelEnable[] = $hotel[$v];
                }
                foreach ($hotel as $k => $v) {
                    if (array_search($k, $data['hotel']['hotel']) === FALSE) {
                        $hotelDisable[] = $v;
                    }
                }
            } else {
                $hotelDisable = $hotel;
            }
            return $this->renderPartial('_item_data_hotel', [
                        'data' => $data,
                        'hotel' => array_merge($hotelEnable, $hotelDisable)
            ]);
        }
    }

    public function actionGetListCity() {
        if (Yii::$app->request->isAjax) {
            $data = [];
            $city_id = Yii::$app->request->post('city_id');
            $city = ArrayHelper::map(City::find()->where(['id' => $city_id, 'status' => TRUE])->asArray()->all(), 'cid', 'name');
            foreach ($city as $k => $v) {
                $data[] = [
                    'cid' => $k,
                    'name' => $v
                ];
            }
            return Json::encode($data);
        }
    }

    public function actionGetListCountry() {
        if (Yii::$app->request->isAjax) {
            $data = [];
            $countriesList = Yii::$app->request->post('country_id');
            $countries = ArrayHelper::map(Country::find()->where(['id' => $countriesList, 'status' => TRUE])->asArray()->all(), 'cid', 'name');
            foreach ($countries as $k => $v) {
                $data[] = [
                    'cid' => $k,
                    'name' => $v
                ];
            }
            return Json::encode($data);
        }
    }

    public function actionUpdateStatus() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $city = Filter::findOne($data['id']);
            $city->$name = (bool) $data['value'];
            $city->update(FALSE);
        }
    }

    public function actionUpdatePromoPrice(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            \backend\models\Settings::updateAll(['body' => $data['value']], ['=', 'name', $data['name']]);
        }
    }

    private function save($data, $id = NULL) {
        $data['Country']['country'] = (isset($data['Country']['country'])) ? array_keys($data['Country']['country']) : [];
        $data['DeptCity']['dept_city'] = (isset($data['DeptCity']['dept_city'])) ? array_keys($data['DeptCity']['dept_city']) : [];
        $data['Length']['length'] = (isset($data['Length']['length'])) ? array_keys($data['Length']['length']) : [];
        $data['Category']['category'] = (isset($data['Category']['category'])) ? array_keys($data['Category']['category']) : [];
        $data['Food']['food'] = (isset($data['Food']['food'])) ? array_keys($data['Food']['food']) : [];
        $filter = ($id === NULL) ? new Filter() : Filter::findOne($id);
        $filter->alias = $data['Filter']['alias'];
        $filter->link = $data['Filter']['link'];
        $filter->name = $data['Filter']['name'];
        $filter->country = serialize($data['Country']);
        $filter->dept_city = serialize($data['DeptCity']);
        if (isset($data['Date']['checked']) && boolval($data['Date']['checked'])) {
            $data['Date']['distinction'] = (strtotime($data['Date']['from']) - strtotime(date('d.m.Y')))/60/60/24;
        }
        $filter->date = serialize($data['Date']);
        $filter->length = serialize($data['Length']);
        $filter->people = serialize($data['People']);
        $filter->category = serialize($data['Category']);
        $filter->food = serialize($data['Food']);
        $filter->price = serialize($data['Price']);
        $filter->city = $data['City']['city'];
        $filter->hotel = $data['Hotel']['hotel'];
        $filter->status = 1;
        if ($filter->save()) {
            $this->refresh();
        }
    }

}
