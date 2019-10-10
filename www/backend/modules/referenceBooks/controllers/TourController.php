<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\modules\referenceBooks\models\DeptCity;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\Tour;
use backend\modules\referenceBooks\models\TourSearch;
use backend\modules\referenceBooks\models\Operator;
use backend\modules\referenceBooks\models\TypeFood;
use backend\modules\referenceBooks\models\Transport;
use backend\modules\referenceBooks\models\SeoMeta;
use yii\data\ActiveDataProvider;
use common\models\Curl;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\helpers\Json;
use backend\modules\specials\models\Special;

class TourController extends Controller {

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
     * @perm('Просмотр туров (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new TourSearch();
        $page = Yii::$app->user->identity->getSettings('tour')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'user_settings' => Yii::$app->user->identity->getSettings('tour'),
                    'page' => $page,
                    'access' => $this->access
        ]);
    }

    public function actionGetCountryList() {
        $сountry = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $name = Yii::$app->request->get('q');
        $сountry = Country::find()->select('cid AS id, name AS text')->where(['like', 'name', $name])->limit(20)->asArray()->all();
        return ['results' => $сountry];
    }

    public function actionGetResortList() {
        $city = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $name = Yii::$app->request->get('q');
        $city = City::find()->select('cid AS id, name AS text')->where(['like', 'name', $name])->limit(20)->asArray()->all();
        return ['results' => $city];
    }

    public function actionGetHotelList() {
        $hotel = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $name = Yii::$app->request->get('q');
        $hotel = Hotel::find()->select('hid AS id, name AS text')->where(['like', 'name', $name])->limit(20)->asArray()->all();
        return ['results' => $hotel];
    }

    public function actionGetApiTour() {
        $hotels_id = [];
        $hotels_info = [];
        $data = Yii::$app->request->post();
        $data['error'] = [];
        $type = $data['country'] || $data['city'] || $data['hotel'];
        if (empty($data['deptCity'])) {
            $data['error'][] = 'Необходимо заполнить «Город отправления»';
        }
        if (!isset($data[$data['type']])) {
            $data['error'][] = 'Необходимо заполнить «Тип»';
        }
        if (empty($type)) {
            $data['error'][] = 'Необходимо заполнить «Cтрану» / «Курорт» / «Отель»';
        }
        if (empty($data['checkIn'])) {
            $data['error'][] = 'Необходимо заполнить временные метки';
        }
        if (empty($data['length'])) {
            $data['error'][] = 'Необходимо заполнить «Кол-во дней»';
        }
        if (!empty($data['people']) && isset($data['children']) && count($data['children']) > 0) {
            $data['people'] = $data['people'] . '0' . implode('', $data['children']);
        }
        $data['food'] = (isset($data['food']) && !empty($data['food'])) ? implode(',', $data['food']) : '';
        if (count($data['error']) > 0) {
            return Json::encode(['type' => 'error', 'data' => implode('<br>', $data['error'])]);
        }
        $type_food = TypeFood::find()->select(['code', 'name'])->asArray()->all();
        $type_food = ArrayHelper::map($type_food, 'code', 'name');
        $operator = Operator::find()->select(['oid', 'name'])->asArray()->all();
        $operator = ArrayHelper::map($operator, 'oid', 'name');
        for ($i = 0; $i < 10; $i++) {
            $curl = Curl::curl('GET', '/api/tours/search', [
                        'deptCity' => $data['deptCity'], 'to' => $data[$data['type']], 'checkIn' => $data['checkIn'],
                        'checkTo' => $data['checkTo'], 'length' => $data['length'], 'people' => $data['people'],
                        'food' => $data['food'], 'page' => $data['page'], 'access_token' => Yii::$app->params['apiToken']
            ]);
            if ($curl['status'] === 200) {
                if (isset($curl['body']['hotels'][$data['page']]) && $curl['body']['lastResult'] == true) {
                    foreach ($curl['body']['hotels'][$data['page']] as $k => $v) {
                        $offer = 0;
                        foreach ($v['offers'] as $k1 => $v1) {
                            if ($v['p'] == $v1['pl']) {
                                $offer = $k1;
                            }
                        }
                        $hotels_info[$k]['food'] = $type_food[$v['offers'][$offer]['f']];
                        $hotels_info[$k]['price'] = number_format($v['offers'][$offer]['pl'], 2, '.', ' ');
                        $hotels_info[$k]['date_begin'] = Yii::$app->formatter->asDate($v['offers'][$offer]['d'], 'php:d.m.Y');
                        $hotels_info[$k]['operator'] = $operator[$v['offers'][$offer]['oi']];
                        $hotels_info[$k]['offer'] = Json::encode($v['offers'][$offer]);
                    }
                    $hotels_id = array_keys($curl['body']['hotels'][$data['page']]);
                    break;
                }
            }
            sleep(1);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Hotel::find()->where(['in', 'hid', $hotels_id]),
            'sort' => FALSE,
            'pagination' => FALSE
        ]);
        $next_page = $data['page'] + 1;
        return Json::encode([
                    'type' => 'success',
                    'page' => $data['page'],
                    'next_page' => $next_page,
                    'count' => $dataProvider->count,
                    'data' => $this->renderPartial('_get_api_tour', [
                        'page' => $data['page'],
                        'hotels_info' => $hotels_info,
                        'dataProvider' => $dataProvider,
                    ])
        ]);
    }

    /**
     * @perm('Добавить тур (справочник)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        $tour = new Tour();
        $tour->scenario = Tour::SCENARIO_USER_SAVE;
        if ($data = Yii::$app->request->post('Tour')) {
            Tour::uncheckPosition($data);
            $this->save($data, $tour);
        }

        $seo = new SeoMeta();
        $dept_city = ArrayHelper::map(DeptCity::find()->select(['cid', 'name'])->where(['status' => TRUE])->asArray()->all(), 'cid', 'name');
        $city = ArrayHelper::map(City::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $operator = ArrayHelper::map(Operator::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $type_food = ArrayHelper::map(TypeFood::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $type_transport = ArrayHelper::map(Transport::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $specials = ArrayHelper::map(Special::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $hotel = ArrayHelper::map(Hotel::find()->select(['hid', 'name'])->where(['status' => TRUE])->asArray()->all(), 'hid', 'name');
        return $this->render('_form', [
                    'tour' => $tour,
                    'seo' => $seo,
                    'operator' => $operator,
                    'type_food' => $type_food,
                    'type_transport' => $type_transport,
                    'dept_city' => $dept_city,
                    'city' => $city,
                    'specials' => $specials,
                    'hotel' => $hotel
        ]);
    }

    public function actionUpdate() {
        $id = Yii::$app->request->get('id');
        $tour = Tour::findOne($id);
        $tour->scenario = Tour::SCENARIO_USER_SAVE;
        if ($data = Yii::$app->request->post('Tour')) {
            $data['SeoMeta'] = Yii::$app->request->post('SeoMeta');
            Tour::uncheckPosition($data);
            $this->save($data, $tour);
        }

        $seo = SeoMeta::find()->where(['alias' => 'tour', 'page_id' => $id])->one();
        if ($seo == NULL) {
            $seo = new SeoMeta();
        }
        $dept_city = ArrayHelper::map(DeptCity::find()->select(['cid', 'name'])->where(['status' => TRUE])->asArray()->all(), 'cid', 'name');
        $city = ArrayHelper::map(City::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $operator = ArrayHelper::map(Operator::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $type_food = ArrayHelper::map(TypeFood::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $type_transport = ArrayHelper::map(Transport::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $specials = ArrayHelper::map(Special::find()->select(['id', 'name'])->where(['status' => TRUE])->asArray()->all(), 'id', 'name');
        $hotel = ArrayHelper::map(Hotel::find()->select(['hid', 'name'])->where(['status' => TRUE])->asArray()->all(), 'hid', 'name');
        return $this->render('_form', [
                    'tour' => $tour,
                    'seo' => $seo,
                    'operator' => $operator,
                    'type_food' => $type_food,
                    'type_transport' => $type_transport,
                    'dept_city' => $dept_city,
                    'city' => $city,
                    'specials' => $specials,
                    'hotel' => $hotel
        ]);
    }

    public function actionDelete() {
        $id = Yii::$app->request->get('id');
        Tour::deleteAll(['id' => $id]);
        $this->redirect(['/referenceBooks/tour']);
    }

    /**
     * @perm('Создать тур с API отпуска (справочник)')
     */
    public function actionCreateApiTour() {
        $this->access->accessAction();
        $dept_city = ArrayHelper::map(DeptCity::find()->select(['cid', 'name'])->where(['status' => TRUE])->asArray()->all(), 'cid', 'name');
        $type_food = ArrayHelper::map(TypeFood::find()->where(['status' => TRUE])->asArray()->all(), 'code', 'name');
        return $this->render('_create_api_tour', [
                    'dept_city' => $dept_city,
                    'type_food' => $type_food
        ]);
    }

    public function actionAddApiTour() {
        $data = Yii::$app->request->post();
        $data['info'] = Json::decode($data['info']);
        Tour::uncheckPosition($data);
        $type_food = ArrayHelper::map(TypeFood::find()->select(['code', 'id'])->asArray()->all(), 'code', 'id');
        $type_transport = Transport::find()->select(['code', 'id'])->asArray()->all();
        $type_transport = ArrayHelper::map($type_transport, 'code', 'id');
        $city_id = City::find()->select(['city.id'])->where(['hotel.hid' => $data['hid']])
            ->leftJoin('hotel', 'hotel.city_id = city.cid')->asArray()->one()['id'];
        $this->save([
            'media_id' => 1,
            'seo_id' => 1,
            'stock_id' => 0,
            'operator_id' => Operator::find()->select(['id'])->where(['oid' => $data['info']['oi']])->asArray()->one()['id'],
            'dept_city_id' => $data['info']['c'],
            'city_id' => $city_id,
            'hotel_id' => $data['hid'],
            'type_number_id' => 1,
            'category_number_id' => 1,
            'type_food_id' => $type_food[$data['info']['f']],
            'type_transport_id' => $type_transport[$data['info']['t']],
            'departure_id' => 1,
            'arrival_id' => 1,
            'title' => 'Test',
            'type_description' => 1,
            'description' => 1,
            'price' => $data['info']['pl'],
            'old_price' => 0,
            'promo_price' => 0,
            'sale' => 0,
            'currency' => 'uah',
            'length' => $data['info']['n'],
            'date_begin' => date('Y-m-d H:i:s'),
            'date_end' => $data['info']['d'],
            'date_end_sale' => $data['info']['d'],
            'date_departure' => isset($data['info']['to']['from'][0]['begin']) ? $data['info']['to']['from'][0]['begin'] : $data['info']['d'],
            'date_arrival' => isset($data['info']['to']['to'][0]['end']) ? $data['info']['to']['to'][0]['end'] : $data['info']['dt'],
            'status' => TRUE,
            'main' => $data['main'],
            'recommend' => $data['recommend'],
            'hot' => $data['hot'],
            'sync' => TRUE
                ], new Tour(), FALSE);
    }

    private function save($data, Tour $tour, $redirect = TRUE) {
        $tour->media_id = 1;
        $tour->seo_id = 1;
        $tour->stock_id = isset($data['stock_id']) && !empty($data['stock_id']) ? $data['stock_id'] : 0;
        $tour->operator_id = $data['operator_id'];
        $tour->dept_city_id = $data['dept_city_id'];
        $tour->city_id = $data['city_id'];
        $tour->hotel_id = $data['hotel_id'];
        $tour->type_number_id = 1;
        $tour->category_number_id = 1;
        $tour->type_food_id = $data['type_food_id'];
        $tour->type_transport_id = $data['type_transport_id'];
        $tour->departure_id = 1;
        $tour->arrival_id = 1;
        $tour->title = $data['title'];
        $tour->type_description = $data['type_description'];
        $tour->description = $data['description'];
        $tour->price = $data['price'];
        $tour->old_price = $data['old_price'];
        $tour->promo_price = 0;
        $tour->sale = $data['sale'];
        $tour->currency = $data['currency'];
        $tour->length = $data['length'];
        $tour->date_begin = Yii::$app->formatter->asDate($data['date_begin'], 'php:Y-m-d H:i:s');
        $tour->date_end = $data['date_end'];
        $tour->date_end_sale = $data['date_end_sale'];
        $tour->date_departure = $data['date_departure'];
        $tour->date_arrival = $data['date_arrival'];
        $tour->status = TRUE;
        $tour->main = $data['main'];
        $tour->recommend = $data['recommend'];
        $tour->hot = $data['hot'];
        $tour->sync = TRUE;
        if ($tour->validate()) {
            $tour->save();
            if ($redirect) {
                $this->redirect(['/referenceBooks/tour']);
            }
        }
    }

    public function actionGetListHotel() {
        if (Yii::$app->request->isAjax) {
            $data = [];
            $city_id = Yii::$app->request->post('city_id');
            $city = City::find()->select('cid')->where(['id' => $city_id, 'status' => TRUE])->asArray()->one()['cid'];
            $hotel = ArrayHelper::map(Hotel::find()->where(['city_id' => $city, 'status' => TRUE])->asArray()->all(), 'hid', 'name');
            foreach ($hotel as $k => $v) {
                $data[] = [
                    'hid' => $k,
                    'name' => $v
                ];
            }
            return Json::encode($data);
        }
    }

    public function actionChangePosition() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            Tour::updateAll([$data['field'] => 0], [$data['field'] => $data['value']]);
            $tour = Tour::find()->where(['id' => $data['id']])->one();
            $tour[$data['field']] = $data['value'];
            $tour->save();
        }
    }

    public function actionUpdateStatus() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $tour = Tour::findOne($data['id']);
            $tour->$name = (bool) $data['value'];
            $tour->update(FALSE);
        }
    }

    public function actionDeleteCheckedTour() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $count = Tour::deleteAll(['id' => $data['list']]);
            return Json::encode($count);
        }
    }
}
