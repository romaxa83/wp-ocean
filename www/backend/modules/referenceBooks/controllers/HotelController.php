<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\HotelSearch;
use backend\modules\referenceBooks\models\TypeHotel;
use yii\helpers\ArrayHelper;
use common\service\CacheService;
use backend\modules\referenceBooks\models\Category;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\TypeTour;
use backend\modules\referenceBooks\models\Service;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use backend\modules\referenceBooks\models\HotelService;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Address;
use yii\filters\AccessControl;
use backend\modules\referenceBooks\models\SeoMeta;

class HotelController extends Controller {

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
     * @perm('Просмотр отелей (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new HotelSearch();
        $page = Yii::$app->user->identity->getSettings('hotel')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'page' => $page,
                    'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание отеля (справочник)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        $hotel = new Hotel();
        $address = new Address();
        if (Yii::$app->request->isPost) {
            $data['hotel'] = Yii::$app->request->post('Hotel');
            $data['address'] = Yii::$app->request->post('Address');
            $this->save($data);
        }
        $data = $this->getHotelData();
        $seo = new SeoMeta();
        return $this->render('_form', [
                    'hotel' => $hotel,
                    'address' => $address,
                    'type_hotel' => $data['type_hotel'],
                    'type_tour' => $data['type_tour'],
                    'category' => $data['category'],
                    'country' => $data['country'],
                    'service_type' => $data['service_type'],
                    'service_data' => $data['service_data'],
                    'rating' => $data['rating'],
                    'service_data_json' => $data['service_data_json'],
                    'seo' => $seo
        ]);
    }

    /**
     * @perm('Редактирование отеля (справочник)')
     */
    public function actionUpdate() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        $hotel = Hotel::find()->where(['id' => $id])->with('hotelService')->with('address')->with('rating')->one();
        $address = Address::find()->where(['hotel_id' => $id])->one();
        if (Yii::$app->request->isPost) {
            $data['hotel'] = Yii::$app->request->post('Hotel');
            $data['address'] = Yii::$app->request->post('Address');
            $data['seo'] = Yii::$app->request->post('SeoMeta');
            $this->save($data, $id);
        }
        $data = $this->getHotelData($id, $hotel->rating);
        $seo = SeoMeta::find()->where(['page_id' => $id, 'alias' => 'hotel'])->one();
        if ($seo === NULL) {
            $seo = new SeoMeta();
        }
        return $this->render('_form', [
                    'hotel' => $hotel,
                    'address' => $address,
                    'type_hotel' => $data['type_hotel'],
                    'type_tour' => $data['type_tour'],
                    'category' => $data['category'],
                    'country' => $data['country'],
                    'service_type' => $data['service_type'],
                    'service_data' => $data['service_data'],
                    'rating' => $data['rating'],
                    'service_data_json' => $data['service_data_json'],
                    'seo' => $seo
        ]);
    }

    /**
     * @perm('Удаление отеля (справочник)')
     */
    public function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Hotel::deleteAll(['id' => $id]);
        $this->redirect(['/referenceBooks/hotel']);
    }

    public function actionUpdatePosition() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('item');
            foreach ($data as $k => $v) {
                Hotel::updateAll(['position' => $k], ['=', 'id', $v]);
            }
        }
    }

    public function actionRenderContentView() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $data['hotel'] = Json::decode($data['hotel']);
            $media_id = Hotel::find()->asArray()->select(['media_id'])->where(['id' => $data['media_id']])->one();
            if (isset($data['hotel'][0])) {
                $media_id = ($media_id['media_id'] === NULL) ? $data['hotel'][0] : $media_id['media_id'];
            }
            $dataProvider = new ArrayDataProvider([
                'allModels' => (count($data['hotel']) > 0) ? Mediafile::find()->filterWhere(['in', 'id', $data['hotel']])->asArray()->all() : NULL,
                'pagination' => FALSE
            ]);
            return $this->renderPartial('_media', [
                        'dataProvider' => $dataProvider,
                        'media_id' => $media_id
            ]);
        }
    }

    private function getHotelData($id = null, $rating = []) {
        $vote = 0;
        $count = 0;
        $data = [];
        $temp = [];
        $data['type_hotel'] = TypeHotel::find()->select(['id', 'name'])->asArray()->where(['status' => TRUE])->all();
        $data['type_hotel'] = ArrayHelper::map($data['type_hotel'], 'id', 'name');
        $data['category'] = Category::find()->select(['id', 'name'])->asArray()->where(['status' => TRUE])->all();
        $data['category'] = ArrayHelper::map($data['category'], 'id', 'name');
        $data['country'] = Country::find()->select(['cid', 'name'])->asArray()->where(['status' => TRUE])->all();
        $data['country'] = ArrayHelper::map($data['country'], 'cid', 'name');
        $data['type_tour'] = TypeTour::find()->select(['id', 'name'])->asArray()->where(['status' => TRUE])->all();
        $data['type_tour'] = ArrayHelper::map($data['type_tour'], 'id', 'name');
        $data['service'] = Service::find()->orderBy(['type' => SORT_ASC])->all();
        $data['service_type'] = ArrayHelper::getColumn(ArrayHelper::index($data['service'], function($service_data) {
                            return $service_data->type;
                        }), 'type');
        $hs = HotelService::find()->where(['hotel_id' => $id])->asArray()->with('service')->all();
        $data['service_data_json'] = Json::encode(['insert' => [], 'update' => [], 'delete' => []]);
        foreach ($hs as $v) {
            $temp[$v['service']['type']][] = $v;
        }
        $data['service_data'] = [];
        foreach ($data['service'] as $v) {
            $data['service_data'][$v->type] = new ArrayDataProvider([
                'allModels' => (isset($temp[$v->type])) ? $temp[$v->type] : NULL,
                'sort' => FALSE
            ]);
        }
        $data['rating'] = ArrayHelper::toArray([]);
        foreach ($data['rating'] as $v) {
            $count += $v['count'];
            $vote += $v['vote'];
        }
        array_unshift($data['rating'], [
            'name' => 'Количество отзывов',
            'vote' => $count
                ], [
            'name' => 'Оценка отеля',
            'vote' => ($vote != 0) ? ($vote / count($data['rating'])) : 0
        ]);
        $data['rating'] = new ArrayDataProvider([
            'allModels' => $data['rating']
        ]);
        return $data;
    }

    private function save($data, $id = NULL) {
        $hotel = ($id === NULL) ? new Hotel() : Hotel::findOne($id);
        if ($id === NULL) {
            $hid = Hotel::find()->select(['id'])->orderBy(['id' => SORT_DESC])->limit(1)->asArray()->one();
            $hotel->hid = (int) '9' . $hid['id'];
        }
        if (isset($data['hotel']['media_id']) && !empty($data['hotel']['media_id'])) {
            $hotel->media_id = $data['hotel']['media_id'];
        }
        $hotel->country_id = $data['hotel']['country_id'];
        $hotel->city_id = $data['hotel']['city_id'];
        $hotel->category_id = $data['hotel']['category_id'];
        $hotel->type_id = $data['hotel']['type_id'];
        $hotel->view_id = $data['hotel']['view_id'];
        $hotel->name = $data['hotel']['name'];
        $hotel->alias = $data['hotel']['alias'];
        $hotel->status = (isset($data['hotel']['status'])) ? $data['hotel']['status'] : FALSE;
        $hotel->sync = (isset($data['hotel']['sync'])) ? $data['hotel']['sync'] : FALSE;
        $hotel->gallery = $data['hotel']['gallery_data'];
        $hotel->save();
        $address = Address::find()->where(['hotel_id' => $hotel->id])->one();
        if ($address === NULL) {
            $address = new Address();
        }
        $address->hotel_id = $hotel->id;
        $address->address = $data['address']['address'];
        $address->phone = $data['address']['phone'];
        $address->email = $data['address']['email'];
        $address->site = $data['address']['site'];
        $address->data_source = $data['address']['data_source'];
        $address->lat = $data['address']['lat'];
        $address->lng = $data['address']['lng'];
        $address->zoom = $data['address']['zoom'];
        $address->location = $data['address']['location'];
        $address->general_description = $data['address']['general_description'];
        $address->location_description = $data['address']['location_description'];
        $address->beach_type = $data['address']['beach_type'];
        $address->beach_description = $data['address']['beach_description'];
        $address->food_description = $data['address']['food_description'];
        $address->distance_sea = $data['address']['distance_sea'];
        $address->location_animals = $data['address']['location_animals'];
        $address->additional_information = $data['address']['additional_information'];
        $address->save();
        $data['hotel']['hotel_service_data'] = Json::decode($data['hotel']['hotel_service_data']);
        foreach ($data['hotel']['hotel_service_data']['insert'] as $v) {
            $hs = new HotelService();
            $hs->hotel_id = $hotel->id;
            $hs->hid = $v['hid'];
            $hs->service_id = $v['service_id'];
            $hs->type = $v['type'];
            $hs->price = $v['price'];
            $hs->sync = TRUE;
            $hs->save();
        }
        $seo = SeoMeta::find()->where(['page_id' => $hotel->id, 'alias' => 'hotel'])->one();
        if ($seo === NULL) {
            $seo = new SeoMeta();
        }
        $seo->page_id = $hotel->id;
        $seo->h1 = $data['seo']['h1'];
        $seo->title = $data['seo']['title'];
        $seo->keywords = $data['seo']['keywords'];
        $seo->description = $data['seo']['description'];
        $seo->seo_text = $data['seo']['seo_text'];
        $seo->language = 'ru';
        $seo->parent_id = NULL;
        $seo->alias = 'hotel';
        $seo->save();
        $this->redirect(['/referenceBooks/hotel']);
    }

    /**
     * @perm('Изменение отеля (справочник)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $hotel = Hotel::findOne($data['id']);
            $hotel->$name = (bool) $data['value'];
            $hotel->update(FALSE);
        }
    }

    public function actionGetServicesName() {
        if (Yii::$app->request->isAjax) {
            $group = Yii::$app->request->post('id');
            $service = Service::find()->where(['type' => $group])->asArray()->all();
            return Json::encode($service);
        }
    }

}
