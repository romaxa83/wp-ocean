<?php

namespace backend\modules\filter\widgets\filter;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use DateTime;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\filter\models\Filter;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\DeptCity;
use backend\modules\referenceBooks\models\Category;
use backend\modules\referenceBooks\models\TypeFood;

class FilterWidget extends Widget {

    public $alias;
    public $filter_link;
    public $data;
    private $filter;
    private $country_cid;

    public function init() {
        parent::init();
    }

    public function run() {
        $filter = Filter::find()->where(['alias' => $this->alias])->asArray()->one();

        if ($filter == NULL || $filter['status'] == 0) {
            return false;
        }
        $this->filter = $filter;
        return $this->render('filter', [
                    'alias' => $this->alias,
                    'data' => $this->data,
                    'country' => $this->getCountry(),
                    'dept_city' => $this->getDeptCity(),
                    'date' => $this->getDate(),
                    'length' => $this->getLength(),
                    'people' => $this->getPeople(),
                    'category' => $this->getCategory(),
                    'food' => $this->getFood(),
                    'price' => $this->getPrice(),
                    'city' => $this->getCity(),
                    'hotel' => $this->getHotel(),
                    'default' => $this->getDefaultValues()
        ]);
    }

    private function getCountry() {
        $country = [];
        $this->filter['country'] = unserialize($this->filter['country']);
        $country_list = Country::find()->select(['id', 'cid', 'alias', 'name'])->where(['status' => TRUE])->asArray()->all();
        $country_list = ArrayHelper::index($country_list, 'id');
        foreach ($this->filter['country']['country'] as $v) {
            if (isset($country_list[$v])) {
                $country['country'][] = $country_list[$v];
            }
        }
        $country['priority'] = (isset($this->filter['country']['priority'])) ? $this->filter['country']['priority'] : 0;
        $country['default'] = (isset($this->filter['country']['default'])) ? $this->filter['country']['default'] : 0;
        $country['priority'] += 1;
        $this->country_cid = Country::find()->select(['cid'])->where(['id' => $country['default'], 'status' => TRUE])->asArray()->one()['cid'];
        if (isset($this->data['country'])) {
            foreach ($country_list as $v) {
                if ($this->data['country'] == $v['alias']) {
                    $country['default'] = $v['id'];
                }
            }
        }
        return $country;
    }

    private function getDeptCity() {
        $dept_city = [];
        $this->filter['dept_city'] = unserialize($this->filter['dept_city']);
        $dept_city_list = DeptCity::find()->select(['id', 'cid', 'alias', 'name'])->where(['status' => TRUE])->asArray()->all();
        $dept_city_list = ArrayHelper::index($dept_city_list, 'id');
        foreach ($this->filter['dept_city']['dept_city'] as $v) {
            if (isset($dept_city_list[$v])) {
                $dept_city['dept_city'][] = $dept_city_list[$v];
            }
        }
        $dept_city['default'] = (isset($this->filter['dept_city']['default'])) ? $this->filter['dept_city']['default'] : 0;
        if (isset($this->data['dept_city'])) {
            foreach ($dept_city_list as $v) {
                if ($this->data['dept_city'] == $v['alias']) {
                    $dept_city['default'] = $v['id'];
                }
            }
        }
        return $dept_city;
    }

    private function getDate() {
        $this->filter['date'] = unserialize($this->filter['date']);
        $date['default'] = isset($this->filter['date']['default']) ? $this->filter['date']['default'] : 14;
        if (isset($this->filter['date']['checked']) && $this->filter['date']['checked'] > 0
            && isset($this->filter['date']['distinction']) && $this->filter['date']['distinction'] >= 0) {
            $date['begin'] = date('d.m.Y', strtotime(' + ' . $this->filter['date']['distinction'] . ' days'));
        } else {
            $date['begin'] = isset($this->filter['date']['from']) ? $this->filter['date']['from'] : date('d.m.Y', strtotime(' + 14 days'));
        }
        $date['end'] = date('d.m.Y', strtotime($date['begin'] . ' + ' . $date['default'] . ' days'));

        if (isset($this->data['date_from']) && isset($this->data['date_to'])) {
            if ($this->validateDate($this->data['date_from'], 'd.m.Y')) {
                $date['begin'] = $this->data['date_from'];
            }
            if ($this->validateDate($this->data['date_to'], 'd.m.Y')) {
                $date['end'] = $this->data['date_to'];
            }
        }
        return $date;
    }

    private function getLength() {
        $length = [];
        $this->filter['length'] = unserialize($this->filter['length']);
        $length['limit'] = [$this->filter['length']['min'], $this->filter['length']['max']];
        $length['range'] = $this->filter['length']['range'];
        $length['length'] = (isset($this->data['length']) && !empty($this->data['length'])) ? $this->data['length'] : $this->filter['length']['min_default'];
        $length['lengthTo'] = (isset($this->data['lengthTo']) && !empty($this->data['lengthTo'])) ? $this->data['lengthTo'] : $this->filter['length']['max_default'];
        return $length;
    }

    private function getPeople() {
        $people = [];
        $this->filter['people'] = unserialize($this->filter['people']);
        $people['default'] = (isset($this->filter['people']['default'])) ? $this->filter['people']['default'] : 0;
        if (isset($this->data['people'])) {
            $people['default'] = $this->data['people'];
        }
        return $people;
    }

    private function getCategory() {
        $category = [];
        $this->filter['category'] = unserialize($this->filter['category']);
        $category_list = Category::find()->select(['id', 'code', 'name'])->where(['status' => TRUE])->asArray()->all();
        $category_list = ArrayHelper::index($category_list, 'id');
        foreach ($this->filter['category']['category'] as $v) {
            if (isset($category_list[$v])) {
                $category['category'][] = $category_list[$v];
            }
        }
        $category['default'] = (isset($this->filter['category']['default'])) ? [$this->filter['category']['default']] : [0];
        if (isset($this->data['stars'])) {
            $category['default'] = explode(',', $this->data['stars']);
        }
        return $category;
    }

    private function getFood() {
        $food = [];
        $this->filter['food'] = unserialize($this->filter['food']);
        $food_list = TypeFood::find()->select(['id', 'code', 'name'])->where(['status' => TRUE])->asArray()->all();
        $food_list = ArrayHelper::index($food_list, 'id');
        foreach ($this->filter['food']['food'] as $v) {
            if (isset($food_list[$v])) {
                $food['food'][] = $food_list[$v];
            }
        }
        $food['default'] = (isset($this->filter['food']['default'])) ? [$this->filter['food']['default']] : [];
        if (isset($this->data['food'])) {
            $food['default'] = [];
            $food_default = explode(',', $this->data['food']);
            foreach ($food_list as $v) {
                if (array_search($v['code'], $food_default) !== FALSE) {
                    $food['default'][] = $v['id'];
                }
            }
        }
        return $food;
    }

    private function getPrice() {
        $this->filter['price'] = unserialize($this->filter['price']);
        $this->filter['price']['price_min'] = (isset($this->data['priceMin'])) ? $this->data['priceMin'] : $this->filter['price']['from'];
        $this->filter['price']['price_max'] = (isset($this->data['priceMax'])) ? $this->data['priceMax'] : $this->filter['price']['to'];
        $this->filter['price']['defaultCurrency'] = $this->filter['price']['currency'];
        if (isset($this->data['filterCurrency'])) {
            $this->filter['price']['currency'] = $this->data['filterCurrency'];
        }
        return $this->filter['price'];
    }

    private function getCity() {
        $city = [];
        $this->filter['city'] = Json::decode($this->filter['city']);
        if (isset($this->filter['city'][$this->country_cid])) {
            $city_list = City::find()->select(['id', 'cid', 'name', 'alias'])->where(['country_id' => $this->country_cid, 'status' => TRUE])->asArray()->all();
            $city_list = ArrayHelper::index($city_list, 'id');

            foreach ($this->filter['city'][$this->country_cid] as $v) {
                if (isset($city_list[$v])) {
                    $city['city'][] = $city_list[$v];
                }
            }
            $city['default'] = (isset($this->filter['city']['default'])) ? [$this->filter['city']['default']] : [];
            if (isset($this->data['city'])) {
                $exp_city = explode(':', $this->data['city']);
                foreach ($city_list as $v) {
                    if (array_search($v['alias'], $exp_city) !== FALSE) {
                        $city['default'][] = $v['id'];
                    }
                }
            }
        }
        return $city;
    }

    private function getHotel() {
        $hotel = [];
        $this->filter['hotel'] = Json::decode($this->filter['hotel']);
        if (isset($this->filter['hotel'][$this->country_cid])) {
            $hotel_list = Hotel::find()->select(['id', 'hid', 'country_id', 'name', 'alias'])->where(['country_id' => $this->country_cid, 'status' => TRUE])->asArray()->all();
            $hotel_list = ArrayHelper::index($hotel_list, 'id');
            foreach ($this->filter['hotel'][$this->country_cid] as $v) {
                foreach ($v as $v1) {
                    if (isset($hotel_list[$v1])) {
                        $hotel['hotel'][] = $hotel_list[$v1];
                    }
                }
            }
            $hotel['default'] = (isset($this->filter['hotel']['default'])) ? [$this->filter['hotel']['default']] : [];
            if (Yii::$app->session->has('filterHotels') && !empty(Yii::$app->session->get('filterHotels'))) {
                $filterHotels = explode(',', Yii::$app->session->get('filterHotels'));
                foreach ($hotel_list as $v) {
                    if (array_search($v['alias'], $filterHotels) !== FALSE) {
                        $hotel['default'][] = $v['id'];
                    }
                }
            }
        }
        return $hotel;
    }

    private function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    private function getDefaultValues() {
        $default_values = [];
        $default_values['countryCode'] = Country::find()->select('cid')->where(['id' => $this->filter['country']['default']])->asArray()->one()['cid'] ?? null;
        $default_values['filterCity'] = DeptCity::find()->select('cid')->where(['id' => $this->filter['dept_city']['default']])->asArray()->one()['cid'] ?? null;
        if (isset($this->filter['date']['checked']) && $this->filter['date']['checked'] > 0
            && isset($this->filter['date']['distinction']) && $this->filter['date']['distinction'] >= 0) {
            $default_values['filterDateStart'] = date('d.m.Y', strtotime(' + ' . $this->filter['date']['distinction'] . ' days'));
            $default_values['filterDateEnd'] = date('d.m.Y', strtotime($default_values['filterDateStart'] . '+' . $this->filter['date']['default'] . ' days'));
        } else {
            $default_values['filterDateStart'] = isset($this->filter['date']['from']) ? $this->filter['date']['from'] : date('d.m.Y', strtotime(' + 14 days'));
            $default_values['filterDateEnd'] = isset($this->filter['date']['default']) && isset($this->filter['date']['from']) ? date('d.m.Y', strtotime($this->filter['date']['from'] . '+' . $this->filter['date']['default'] . ' days')) : date('d.m.Y', strtotime(' + 28 days'));
        }
        $default_values['filterDaysFrom'] = $this->filter['length']['min_default'] ?? null;
        $default_values['filterDaysTo'] = $this->filter['length']['max_default'] ?? null;
        $default_values['filterPeople'] = $this->filter['people']['default'] ?? null;
        $default_values['filterCatHotelLink'] = $this->filter['category']['default'] ?? null;
        $default_values['filterNutrition'] = isset($this->filter['food']['default']) ? TypeFood::find()->select(['code'])->where(['id' => $this->filter['food']['default']])->asArray()->one()['code'] : null;
        $default_values['priceMin'] = $this->filter['price']['from'] ?? null;
        $default_values['priceMax'] = $this->filter['price']['to'] ?? null;
        $default_values['currency'] = $this->filter['price']['defaultCurrency'] ?? null;
        $default_values['filterResorts'] = isset($this->filter['city']['default']) ? City::find()->select(['cid'])->where(['id' => $this->filter['city']['default']])->asArray()->one()['cid'] : null;
        $default_values['filterHotelsTitles'] = isset($this->filter['hotel']['default']) ? Hotel::find()->select(['name'])->where(['id' => $this->filter['hotel']['default']])->asArray()->one()['name'] : null;
        return $default_values;
    }
}
