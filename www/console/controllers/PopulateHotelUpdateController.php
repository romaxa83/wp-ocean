<?php


namespace console\controllers;


use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\Hotel;
use console\models\HotelHash;
use Yii;
use yii\console\Controller;
use \yii\db\Query;

class PopulateHotelUpdateController extends Controller {
    public function actionPopulate($country_id, $limit = 10) {
        if (!Country::find()
            ->where(['cid' => $country_id])
            ->exists()) {
            echo 'Country with such cid doesn\'t exist' . PHP_EOL;
            exit();
        }

        if (!Yii::$app->cache->exists('hotel_hash_offset')) {
            Yii::$app->cache->set('hotel_hash_offset', array($country_id => 0));
        }

        if (!isset(Yii::$app->cache->get('hotel_hash_offset')[$country_id])) {
            $data = Yii::$app->cache->get('hotel_hash_offset');
            $data[$country_id] = 0;
            Yii::$app->cache->set('hotel_hash_offset', $data);
        }

        $offsets = Yii::$app->cache->get('hotel_hash_offset');
        if ($offsets[$country_id] > Hotel::find()->where(['country_id' => $country_id])->count()) {
            $offsets[$country_id] = 0;
            Yii::$app->cache->set('hotel_hash_offset', $offsets);
            echo 'Records in the database ended, offset value on cache was cleaned' . PHP_EOL;
            exit();
        }

        $hotels = (new Query())
            ->select(['hid', 'country_id'])
            ->from('hotel')
            ->where(['country_id' => $country_id])
            ->limit($limit)
            ->offset($offsets[$country_id])
            ->all();

        $update = [];
        foreach ($hotels as $h) {
            if (!HotelHash::find()
                ->where(['hid' => $h['hid']])
                ->exists()) {
                $hotel_hash = new HotelHash;
                $hotel_hash->hid = $h['hid'];
                $hotel_hash->country_id = $h['country_id'];
                $hotel_hash->hash = $hotel_hash->getLocalHotelHash();
                $hotel_hash->save();
            }

            $hotel_hash = HotelHash::find()->where(['hid' => $h['hid']])->one();
            if (!($hotel_hash->getRemoteHotelHash() === $hotel_hash->hash ?? $hotel_hash->getLocalHotelHash())) {
                $update[] = $h['hid'];
            }
        }

        if (!Yii::$app->cache->exists('update_hotels')) {
            Yii::$app->cache->set('update_hotels', array());
        }
        $update_hotels = Yii::$app->cache->get('update_hotels');

        Yii::$app->cache->set('update_hotels', array_unique(array_merge($update_hotels, $update)));

        $offsets[$country_id] += $limit;
        Yii::$app->cache->set('hotel_hash_offset', $offsets);
    }


}