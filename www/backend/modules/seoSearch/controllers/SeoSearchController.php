<?php

namespace backend\modules\seoSearch\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use backend\modules\seoSearch\models\SeoSearchSearch;
use backend\modules\seoSearch\models\SeoSearch;
use yii\filters\AccessControl;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\DeptCity;
use backend\modules\referenceBooks\models\City;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\SeoMeta;
use yii\helpers\Json;

class SeoSearchController extends Controller {

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
        $searchModel = new SeoSearchSearch();
        $page = Yii::$app->user->identity->getSettings('seo_search')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'page' => $page
        ]);
    }

    public function actionCreate() {
        if ($data = Yii::$app->request->post()) {
            $this->save($data);
        }
        $seo_search = new SeoSearch();
        $country = Country::find()->select(['id', 'name'])->where(['status' => 1])->asArray()->all();
        $country = ArrayHelper::map($country, 'id', 'name');
        $dept_city = DeptCity::find()->select(['id', 'name'])->where(['status' => 1])->asArray()->all();
        $dept_city = ArrayHelper::map($dept_city, 'id', 'name');
        return $this->render('_form', [
                    'seo_search' => $seo_search,
                    'country' => $country,
                    'dept_city' => $dept_city,
        ]);
    }

    public function actionUpdate() {
        $id = Yii::$app->request->get('id');
        $seo_search = SeoSearch::find()->where(['id' => $id])->with('seo')->one();
        if ($data = Yii::$app->request->post()) {
            $this->save($data, $id);
        }
        $country = Country::find()->select(['id', 'name'])->where(['status' => 1])->asArray()->all();
        $country = ArrayHelper::map($country, 'id', 'name');
        $dept_city = DeptCity::find()->select(['id', 'name'])->where(['status' => 1])->asArray()->all();
        $dept_city = ArrayHelper::map($dept_city, 'id', 'name');
        $city = City::find()->select(['id', 'name'])->where(['status' => 1])->asArray()->all();
        $city = ArrayHelper::map($city, 'id', 'name');
        return $this->render('_form', [
                    'seo_search' => $seo_search,
                    'country' => $country,
                    'dept_city' => $dept_city,
                    'city' => $city
        ]);
    }

    public function actionDelete() {
        $id = Yii::$app->request->get('id');
        SeoSearch::deleteAll(['id' => $id]);
        SeoMeta::deleteAll(['page_id' => $id, 'alias' => 'seo_search']);
        $this->redirect(Url::toRoute(['/seoSearch/seo-search'], TRUE));
    }

    public function actionGetCity() {
        $city = [];
        $data = Yii::$app->request->post();
        $country = Country::findOne($data['country_id']);
        if (isset($country->cid)) {
            $city = City::find()->select(['id', 'name'])->where(['country_id' => $country->cid, 'status' => TRUE])->asArray()->all();
        }
        return Json::encode($city);
    }

    public function actionUpdateStatus() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $city = SeoSearch::findOne($data['id']);
            $city->$name = (bool) $data['value'];
            $city->update(FALSE);
        }
    }

    private function save($data, $id = NULL) {
        if ($id === NULL) {
            $temp = SeoSearch::find()->where([
                        'country_id' => (!empty($data['SeoSearch']['country_id'])) ? $data['SeoSearch']['country_id'] : NULL,
                        'dept_city_id' => (!empty($data['SeoSearch']['dept_city_id'])) ? $data['SeoSearch']['dept_city_id'] : NULL,
                        'city_id' => (!empty($data['SeoSearch']['city_id'])) ? $data['SeoSearch']['city_id'] : NULL
                    ])->asArray()->one();
            if ($temp !== NULL) {
                Yii::$app->session->setFlash('danger', 'Запись не создана. Данные уже существуют под ID:' . $temp['id']);
                return $this->redirect(['/seoSearch/seo-search']);
            }
        }
        $seo_search = ($id === NULL) ? new SeoSearch() : SeoSearch::findOne($id);
        $seo_search->country_id = $data['SeoSearch']['country_id'];
        $seo_search->dept_city_id = $data['SeoSearch']['dept_city_id'];
        $seo_search->city_id = (isset($data['SeoSearch']['city_id'])) ? $data['SeoSearch']['city_id']: NULL;
        $seo_search->status = TRUE;
        if ($seo_search->save()) {
            $seo_meta = ($id === NULL) ? new SeoMeta() : SeoMeta::find()->where(['page_id' => $seo_search->id, 'alias' => 'seo_search'])->one();
            $seo_meta->page_id = $seo_search->id;
            $seo_meta->h1 = $data['Seo']['h1'];
            $seo_meta->title = $data['Seo']['title'];
            $seo_meta->keywords = $data['Seo']['keywords'];
            $seo_meta->description = $data['Seo']['description'];
            $seo_meta->seo_text = $data['Seo']['text'];
            $seo_meta->alias = 'seo_search';
            $seo_meta->save();
        }
        $this->redirect(['/seoSearch/seo-search']);
    }

}
