<?php

namespace frontend\service;

use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\Tour;
use yii\db\Expression;

class TourService {

    public function getRandomTourForCountry($country_id, $hotel_hid, $limit) {
        $time = new \DateTimeImmutable('now');
        $today = $time->format('Y-m-d H:i:s');

        if (Tour::find()->where(['>=', 'date_begin', $today])->exists()) {

            $all_hotels = array_column(Hotel::find()
                            ->select('hid')
                            ->where(['country_id' => $country_id])
                            ->andWhere(['not in', 'hid', $hotel_hid])
                            ->asArray()
                            ->all(), 'hid');

            $tour = Tour::find()
                    ->where(['>=', 'date_begin', $today])
                    ->andWhere(['in', 'hotel_id', $all_hotels])
                    ->orderBy(new Expression('rand()'))
                    ->limit($limit)
                    ->with('hotel')
                    ->with('hotel.cites')
                    ->with('hotel.media')
                    ->with('hotel.reviews')
                    ->with('hotel.countries')
                    ->with('hotel.category')
                    ->with('hotel.address')
                    ->asArray()
                    ->all();

            return $tour;
        }

        return false;
    }

    /**
     * Инициализирует массив с данными для отправки к api
     * @param $hotel_hid
     * @return mixed
     */
    public function initDataApi($hotel_hid): array {
        $default = \Yii::$app->params['dataApiDefault'];
        $date = new \DateTimeImmutable('now');
        $checkIn = $date->format('Y-m-d');
        $checkTo = $date->modify($default['days'] . ' days')->format('Y-m-d');

        $data_api = \Yii::$app->session->get('data_api');

        $data_api['to'] = $hotel_hid;
        //город отправления
        if (!isset($data_api['deptCity'])) {
            $data_api['deptCity'] = $default['deptCityCid'];
        }
        //дата с
        if (!isset($data_api['checkIn'])) {
            $data_api['checkIn'] = $checkIn;
        }
        // дата по
        if (!isset($data_api['checkTo'])) {
            $data_api['checkTo'] = $checkTo;
        }
        // кол-во ночей с
        if (!isset($data_api['length'])) {
            $data_api['length'] = $default['days'];
        }
        // кол-во ночей по
        if (!isset($data_api['lengthTo'])) {
            $data_api['lengthTo'] = $default['days'];
        }
        // кол-во людей
        if (!isset($data_api['people'])) {
            $data_api['people'] = $default['people'];
        }
        // кол-во записей
        if (!isset($data_api['page'])) {
            $data_api['page'] = $default['page'];
        }
        // кол-во записей
        if (!isset($data_api['access_token'])) {
            $data_api['access_token'] = \Yii::$app->params['apiToken'];
        }

        return $data_api;
    }

    public function getDataTourForHotel() {

    }

}
