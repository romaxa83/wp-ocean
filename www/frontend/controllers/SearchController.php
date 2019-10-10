<?php

namespace frontend\controllers;

use backend\modules\content\models\ContentOptions;
use backend\modules\content\models\Page;
use backend\modules\filter\models\Filter;
use Yii;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\Country;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\DeptCity;
use backend\modules\referenceBooks\models\City;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\TypeFood;
use yii\helpers\Json;
use yii\helpers\Url;
use cijic\phpMorphy\Morphy;
use backend\modules\seoSearch\models\SeoSearch;
use yii\db\Expression;
use backend\models\Settings;

class SearchController extends BaseController {

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionSetView() {
        $view = Yii::$app->request->post('view');
        Yii::$app->session->set('search_view', $view);
    }

    public function actionFilter() {
        $data = Yii::$app->request->post();
        if (isset($data['city']) && count($data['city']) > 0) {
            $сities = (isset($data['city']) && count($data['city']) > 0) ? (implode(',', $data['city'])) : '';
            Yii::$app->session->set('filterСities', $сities);
        }

        $data_api = Yii::$app->session->get('data_api');
        $data_api['deptCity'] = DeptCity::find()->select(['cid'])->where(['alias' => $data['dept_city']])->asArray()->one()['cid'];
        Yii::$app->session->set('data_api', $data_api);

        Yii::$app->session->set('filterHotels', $data['session']['hotel']);
        return str_replace('%2C', ',', Url::to('/search/' . $data['country'] . '-' . $data['dept_city'] . ((isset($data['city']) && count($data['city']) > 0) ? '/' . (implode(':', $data['city'])) : FALSE) . '?' . http_build_query($data['additional']), TRUE));
    }

    public function actionIndex() {
        $data = Yii::$app->request->get();
        $country = ArrayHelper::index(Country::find()->select(['alias', 'name', 'nameVn'])->asArray()->all(), 'alias');
        if (isset($data['country']) && !isset($data['dept_city'])) {
            $filter = Filter::find()->select(['alias', 'link'])->where(['status' => 1, 'alias' => $data['country']])->asArray()->one();
            $filter_alias = $filter['alias'];
            $temp = explode('-', $filter['link']);
            $data['country'] = $temp[0];
        } else {
            $filter_alias = 'default';
        }
        if (!isset($data['dept_city'])) {
            $data['dept_city'] = 'kiev';
        }
        $dept_city = DeptCity::find()->select(['rel'])->where(['status' => 1, 'alias' => $data['dept_city']])->asArray()->one();
        $breadcrumbs[] = [
            'href' => Url::to('/', TRUE),
            'name' => 'Главная'
        ];
        if (isset($data['dept_city']) && !empty($data['dept_city']) && isset($data['country']) && !empty($data['country'])) {
            $breadcrumbs[] = [
                'href' => Url::to('/search/' . $data['country'] . '-' . $data['dept_city'], TRUE),
                'name' => mb_strtolower('из <span class="breadcrumb-mark">' . (isset($dept_city['rel']) ? $dept_city['rel'] : '') . '</span> в <span class="breadcrumb-mark">' . $country[$data['country']]['nameVn'] . '</span>')
            ];
        } else {
            if (isset($data['country']) && !empty($data['country'])) {
                $breadcrumbs[] = [
                    'href' => Url::to('/search/' . $data['country'], TRUE),
                    'name' => mb_strtolower('<span class="breadcrumb-mark">' . $country[$data['country']]['nameVn'] . '</span>')
                ];
            }
        }

        if (isset($data['city'])) {
            $city_alias = City::find()->select(['alias', 'name'])->where(['alias' => explode(':', $data['city'])])->asArray()->all();
            $city_alias = ArrayHelper::map($city_alias, 'alias', 'name');
            $breadcrumbs[] = [
                'href' => Url::to(Yii::$app->request->url, TRUE),
                'name' => implode(' и ', $city_alias)
            ];
        }

        $this->renderBreadcrumbs($breadcrumbs);

        if ($seo = $this->getSeoData()) {
            $this->setMetaData($seo);
        } else {
            $seo = $this->setTemplateMetaData();
        }

        return $this->render('index', [
                    'seo' => $seo,
                    'alias' => $filter_alias,
        ]);
    }

    public function actionSearchResult() {
        if (Yii::$app->request->isAjax) {
            $hotels_info = [];
            $hotels = [];
            $hotel_list = [];
            $hotel_review = [];
            $data = Yii::$app->request->post();
            $deptCity = DeptCity::find()->select(['cid', 'rel'])->where(['alias' => $data['dept_city']])->asArray()->one();
            $data_api['deptCity'] = $deptCity['cid'];
            $country = Country::find()->select(['cid', 'name'])->where(['alias' => $data['country']])->asArray()->one();
            $data_api['to'] = $country['cid'];
            $data_api['checkIn'] = date('Y-m-d', strtotime($data['additional']['date_from']));
            $data_api['checkTo'] = date('Y-m-d', strtotime($data['additional']['date_to']));
            $data_api['length'] = $data['additional']['length'] + 1;
            $data_api['lengthTo'] = $data['additional']['lengthTo'] + 1;
            $data_api['people'] = $data['additional']['people'];
            $data_api['page'] = (isset($data['page'])) ? $data['page'] : 1;
            $data_api['stars'] = $data['additional']['stars'];
            $data_api['food'] = $data['additional']['food'];
            $data_api['price'] = $data['additional']['priceMin'];
            $data_api['priceTo'] = $data['additional']['priceMax'];
            $data_api['currency'] = $data['additional']['filterCurrency'];
            $data_api['noPromo'] = (boolean) Settings::find()->where(['name' => 'promo_price'])->asArray()->one()['body'];
            if (strpos($country['name'], 'Бали') !== FALSE) {
                $temp_country = Country::find()->select(['cid'])->where(['like', 'name', 'Индонезия'])->asArray()->one();
                $data_api['to'] = $temp_country['cid'];
                $temp_country = Country::find()->select(['cid'])->where(['like', 'name', 'Бали'])->asArray()->one();
                $temp_city = City::find()->select(['cid'])->where(['country_id' => $temp_country['cid']])->asArray()->all();
                $data_api['toCities'] = implode(',', ArrayHelper::getColumn($temp_city, 'cid'));
            }
            if (strpos($country['name'], 'Индонезия') !== FALSE) {
                $temp_country = Country::find()->select(['cid'])->where(['like', 'name', 'Индонезия'])->asArray()->one();
                $temp_city = City::find()->select(['cid'])->where(['country_id' => $temp_country['cid']])->asArray()->all();
                $data_api['toCities'] = implode(',', ArrayHelper::getColumn($temp_city, 'cid'));
            }
            if (isset($data['city'])) {
                $data_api['toCities'] = implode(',', ArrayHelper::getColumn(City::find()->select('cid')->where(['in', 'alias', $data['city']])->asArray()->all(), 'cid'));
            }
            if (isset($data['session']['hotel'])) {
                $query = Hotel::find()->select('hid')->where(['in', 'alias', explode(',', $data['session']['hotel'])]);
                if (!empty($data['additional']['stars'])) {
                    $query->andWhere(['in', 'category_id', explode(',', $data['additional']['stars'])]);
                }
                $data_api['toHotels'] = implode(',', ArrayHelper::getColumn($query->asArray()->all(), 'hid'));
            }
            $data_api['access_token'] = Yii::$app->params['apiToken'];
            $result = $this->getApiSearchData($data_api);
            if (is_array($result) && count($result) > 0 && $result['hotels'] === NULL) {
                $deptCity = DeptCity::find()->select(['cid', 'rel'])->where(['alias' => 'kiev'])->asArray()->one();
                $data_api['deptCity'] = $deptCity['cid'];
                $result = $this->getApiSearchData($data_api);
            }
            $flag = TRUE;
            if (empty($data_api['toHotels']) && $data['type'] != 'default') {
                $flag = FALSE;
            }
            if (is_array($result) && count($result) > 0 && $result['hotels'] !== NULL && $flag) {
                $type_food = TypeFood::find()->select(['code', 'name'])->asArray()->all();
                $type_food = ArrayHelper::map($type_food, 'code', 'name');
                $r = $result['hotels'][$data_api['page']];
                if (!Yii::$app->cache->exists('missing_hotels')) {
                    Yii::$app->cache->set('missing_hotels', array());
                }
                $missing_hotels = Yii::$app->cache->get('missing_hotels');
                foreach ($r as $k => $v) {
                    $hotels[$k] = $k;
                    if (!Hotel::find()->where(['hid' => $k])->exists()) {
                        $missing_hotels[] = $k;
                    }
                }
                Yii::$app->cache->set('missing_hotels', array_unique($missing_hotels));
                foreach ($r as $k => $v) {
                    if (isset($hotels[$k])) {
                        $offer = 0;
                        $h = $r[$hotels[$k]];
                        foreach ($h['offers'] as $k1 => $v1) {
                            if ($h['p'] == $v1['pl']) {
                                $offer = $k1;
                            }
                        }
                        if (strlen($offer) > 5) {
                            $hotels_info[$hotels[$k]]['dept'] = $deptCity['rel'];
                            $hotels_info[$hotels[$k]]['date_begin'] = Yii::$app->formatter->asDate($h['offers'][$offer]['d'], 'php:d.m.Y');
                            $hotels_info[$hotels[$k]]['length'] = $h['offers'][$offer]['n'];
                            $hotels_info[$hotels[$k]]['room'] = $h['offers'][$offer]['r'];
                            $hotels_info[$hotels[$k]]['food'] = $type_food[$h['offers'][$offer]['f']];
                            $hotels_info[$hotels[$k]]['people'] = $h['offers'][$offer]['a'];
                            $hotels_info[$hotels[$k]]['child'] = $h['offers'][$offer]['h'];
                            $hotels_info[$hotels[$k]]['price'] = $h['offers'][$offer]['pl'];
                            $hotels_info[$hotels[$k]]['i'] = $h['offers'][$offer]['i'];
                        } else {
                            unset($hotels[$k]);
                        }
                    }
                }
            }
            if (count($hotels) > 0) {
                $hotels_query = Hotel::find()->where(['in', 'hid', $hotels]);
                if (!empty($data['additional']['stars'])) {
                    $hotels_query->andWhere(['in', 'category_id', explode(',', $data['additional']['stars'])]);
                }
                $hotel_list = $hotels_query->with('category')->with('cites')->with('countries')->with('hotelService')->asArray()->all();
                $hotel_review = $this->getHotelReview(ArrayHelper::getColumn($hotel_list, 'id'));
                foreach ($hotel_list as $k => $v) {
                    $hotel_list[$k]['media'] = Mediafile::find()->select(['url', 'alt'])->where(['id' => $v['media_id']])->asArray()->one();
                    shuffle($hotel_list[$k]['hotelService']);
                    $hotel_list[$k]['hotelService'] = array_slice($hotel_list[$k]['hotelService'], 0, 6);
                    $hotel_list[$k]['price'] = $hotels_info[$v['hid']]['price'];
                    $hotel_list[$k]['link'] = Url::to(['/tour/' . $v['countries']['alias'] . '/' . $v['cites']['alias'] . '/' . $v['alias'],
                                'deptCity' => $deptCity['cid'],
                                'to' => $v['hid'],
                                'checkIn' => Yii::$app->formatter->asDate($hotels_info[$v['hid']]['date_begin'], 'php:Y-m-d'),
                                'length' => $hotels_info[$v['hid']]['length'],
                                'people' => $hotels_info[$v['hid']]['people'],
                                'offerId' => $hotels_info[$v['hid']]['i']
                                    ], TRUE);
                }
                usort($hotel_list, function($a, $b) {
                    if ($a == $b)
                        return 0;
                    return ($a['price'] < $b['price']) ? -1 : 1;
                });
            }
            Yii::$app->session->remove('filterHotels');
            Yii::$app->session->remove('filterСities');
            $result = [
                'hotels' => $hotels,
                'data_api' => $data_api,
                'hotel_list' => $hotel_list,
                'hotels_info' => $hotels_info,
                'hotel_review' => $hotel_review
            ];
            if ($data_api['page'] == 1) {
                if (count($hotel_list) == 0) {
                    $result['disabled_hotel'] = Hotel::find()->where(['country.alias' => $data['country']])->joinWith('category')->joinWith('cites')->joinWith('countries')->joinWith('address')->joinWith('media')->limit(6)->orderBy(new Expression('rand()'))->asArray()->all();
                    $result['disabled_hotel_review'] = $this->getHotelReview(ArrayHelper::getColumn($result['disabled_hotel'], 'id'));
                }
                return $this->renderPartial('_block_search_result', $result);
            } else {
                $content['page'] = $data_api['page'] + 1;
                $content['content'] = $this->renderPartial('_block_hotels', $result);
                return Json::encode($content);
            }
        }
    }

    private function getSeoData() {
        $seo_search = NULL;
        $data = Yii::$app->request->get();
        if (strpos(Yii::$app->request->getUrl(), '?') === FALSE) {
            $seo_search = SeoSearch::find()->where([
                        'country_id' => (isset($data['country'])) ? Country::find()->select(['id'])->where(['alias' => $data['country']])->asArray()->one()['id'] : NULL,
                        'dept_city_id' => (!empty($data['dept_city'])) ? DeptCity::find()->select(['id'])->where(['alias' => $data['dept_city']])->asArray()->one()['id'] : NULL,
                        'city_id' => (!empty($data['city'])) ? City::find()->where(['alias' => $data['city']])->asArray()->one()['id'] : NULL,
                    ])->with('seo')->asArray()->one();
        }
        if (empty($data)) {
            $seo_search = SeoSearch::find()->where([
                        'country_id' => NULL,
                        'dept_city_id' => NULL,
                        'city_id' => NULL,
                    ])->with('seo')->asArray()->one();
        }
        return $seo_search;
    }

    private function setMetaData($seo) {
        Yii::$app->view->title = (isset($seo['seo']['title'])) ? $seo['seo']['title'] : 'Результаты поиска';
        if (strpos(Yii::$app->request->getUrl(), '?') === FALSE) {
            Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $seo['seo']['keywords']
            ]);
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $seo['seo']['description']
            ]);
        }
    }

    private function setTemplateMetaData() {
        $seo = [];
        $data = Yii::$app->request->get();
        $black_list = ['о', 'и', 'е', 'ё', 'э', 'ы', 'у', 'ю', 'я', 'а'];
        if (isset($data['country']) && !isset($data['dept_city']) && !isset($data['city'])) {
            $template = Country::find()->select(['nameVn'])->where(['alias' => $data['country']])->asArray()->one()['nameVn'];
            Yii::$app->view->title = "Поиск, подбор тура в $template. Найти и подобрать путевку в $template онлайн";
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => "Подбор тура в $template с возможностью бронирования путевки онлайн. "
                . "Подобрать и найти тур в $template по оптимальной цене. Удобный поиск, актуальные предложения."
            ]);
            $seo = [
                'status' => TRUE,
                'seo' => [
                    'h1' => "Поиск туров в $template",
                    'seo_text' => NULL
                ]
            ];
        } else if (isset($data['country']) && isset($data['dept_city']) && !isset($data['city'])) {
            $country = Country::find()->select(['nameVn'])->where(['alias' => $data['country']])->asArray()->one()['nameVn'];
            $dept_city = DeptCity::find()->select(['rel'])->where(['alias' => $data['dept_city']])->asArray()->one()['rel'];
            $template = $country . ' из ' . $dept_city;
            Yii::$app->view->title = "Туры в $template. Купить путевку на отдых онлайн | Пятый Океан";
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => "Подбор тура в $template с возможностью бронирования путевки онлайн. "
                . "Купить тур в $template на отдых по оптимальной цене в туркомпании Пятый Океан."
            ]);
            $seo = [
                'status' => TRUE,
                'seo' => [
                    'h1' => "Туры в $template",
                    'seo_text' => NULL
                ]
            ];
        } else if (isset($data['country']) && !isset($data['dept_city']) && isset($data['city'])) {
            $country = Country::find()->select(['name'])->where(['alias' => $data['country']])->asArray()->one()['name'];
            $city = City::find()->select('nameVn')->where(['=', 'alias', $data['city']])->asArray()->one()['nameVn'];
            $template = $city . ', ' . $country;
            Yii::$app->view->title = "Туры в $template. Купить путевку на отдых онлайн в туркомпании Пятый Океан";
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => "Подбор тура в $template с возможностью бронирования путевки онлайн. "
                . "Купить тур в $template по оптимальной цене в туркомпании Пятый Океан."
            ]);
            $seo = [
                'status' => TRUE,
                'seo' => [
                    'h1' => "Туры в $template",
                    'seo_text' => NULL
                ]
            ];
        } else if (isset($data['country']) && isset($data['dept_city']) && isset($data['city'])) {
            $country = Country::find()->select(['name'])->where(['alias' => $data['country']])->asArray()->one()['name'];
            $dept_city = DeptCity::find()->select(['rel'])->where(['alias' => $data['dept_city']])->asArray()->one()['rel'];
            $data['city'] = explode(':', $data['city']);
            $city = City::find()->select('nameVn')->where(['=', 'alias', $data['city'][0]])->asArray()->one()['nameVn'];
            $template = $city . ', ' . $country . ' с вылетом из ' . $dept_city;
            Yii::$app->view->title = "Туры в $template. Купить путевку на отдых онлайн";
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => "Подбор тура в $template с возможностью бронирования путевки онлайн. "
                . "Купить тур в $template по оптимальной цене в туркомпании Пятый Океан."
            ]);
            $seo = [
                'status' => TRUE,
                'seo' => [
                    'h1' => "Туры в $template",
                    'seo_text' => NULL
                ]
            ];
        }
        return $seo;
    }

}
