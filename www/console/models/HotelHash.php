<?php


namespace console\models;


use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Address;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\HotelService;
use backend\modules\referenceBooks\models\Rating;
use backend\modules\referenceBooks\models\Service;
use backend\modules\referenceBooks\models\TypeHotel;
use backend\modules\referenceBooks\models\TypeTour;
use common\models\Curl;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class HotelHash extends ActiveRecord {

    private $api_data;

    public static function tableName(): string {
        return '{{%hotel_hash}}';
    }

    public function getLocalHotelHash() {
        $hotel = Hotel::find()->select(['hid', 'name', 'alias', 'view_id', 'type_id', 'gallery'])->where(['hid' => $this->hid])->asArray()->one();
        if (isset($hotel['gallery']) && !empty($hotel['gallery'])) {
            $gallery = str_replace(['[', ']'], '', $hotel['gallery']);
            $gallery = explode(',', $gallery);
            $gallery = Mediafile::find()->select(['url'])->where(['id' => $gallery])->asArray()->all();
            $hotel['gallery'] = [];
            foreach ($gallery as $g) {
                $hotel['gallery'][] = substr($g['url'], 23);
            }
            sort($hotel['gallery']);
        }
        $address = Address::find()
            ->select(['address', 'phone', 'email', 'site', 'lat', 'lng', 'zoom', 'general_description', 'general_description', 'location_description', 'food_description', 'beach_description'])
            ->where(['hid' => $this->hid])
            ->asArray()
            ->one();
        if (!isset($address)) {
            $hotel['address'] = null;
        } else {
            $hotel = array_merge($hotel, $address);
        }

        $rating = ArrayHelper::index(Rating::find()->select(['rid', 'name', 'vote', 'count'])->where(['hotel_id' => $this->hid])->asArray()->all(), 'rid');
        $hotel['rating'] = $rating;

        $service = ArrayHelper::index(HotelService::find()->select(['hid', 'service_id', 'type'])->where(['hid' => $this->hid])->asArray()->all(), 'service_id');
        ksort($service);
        $hotel['service'] = $service;
        return $this->getHash($hotel);
    }

    public function getRemoteHotelHash() {
        $result = $this->api_data ?? $this->getApiSearchData();
        $type_tour = ArrayHelper::index(TypeTour::find()->asArray()->all(), 'code');
        $type_hotel = ArrayHelper::index(TypeHotel::find()->asArray()->all(), 'code');
        $hotel = array('hid' => strval($this->hid));
        $hotel['name'] = (isset($result['hotel']['nm'])) ? strip_tags($result['hotel']['nm']) : NULL;
        $hotel['alias'] = (isset($result['hotel']['h'])) ? strip_tags($result['hotel']['h']) : NULL;
        $hotel['view_id'] = (isset($result['hotel']['tp']['i'])) ? $type_tour[$result['hotel']['tp']['i']]['id'] : NULL;
        $hotel['type_id'] = (isset($result['hotel']['fm']['i'])) ? $type_hotel[$result['hotel']['fm']['i']]['id'] : NULL;
        $gallery = $result['hotel']['f'];
        sort($gallery);
        $hotel['gallery'] = (isset($result['hotel']['f']) && !empty($result['hotel']['f'])) ? $gallery : NULL;

        $hotel['address'] = (isset($result['hotel']['ad']['a'])) ? strip_tags($result['hotel']['ad']['a']) : NULL;
        $hotel['phone'] = (isset($result['hotel']['ad']['ph'])) ? strip_tags($result['hotel']['ad']['ph']) : NULL;
        $hotel['email'] = (isset($result['hotel']['ad']['ml'])) ? strip_tags($result['hotel']['ad']['ml']) : NULL;
        $hotel['site'] = (isset($result['hotel']['ad']['u'])) ? strip_tags($result['hotel']['ad']['u']) : NULL;
        $hotel['lat'] = (isset($result['hotel']['g']['a'])) ? strip_tags($result['hotel']['g']['a']) : NULL;
        $hotel['lng'] = (isset($result['hotel']['g']['o'])) ? strip_tags($result['hotel']['g']['o']) : NULL;
        $hotel['zoom'] = (isset($result['hotel']['g']['z'])) ? strip_tags($result['hotel']['g']['z']) : NULL;
        $hotel['general_description'] = (isset($result['hotel']['o']['dc'])) ? strip_tags($result['hotel']['o']['dc']) : NULL;
        $hotel['location_description'] = (isset($result['hotel']['o']['di'])) ? strip_tags($result['hotel']['o']['di']) : NULL;
        $hotel['food_description'] = (isset($result['hotel']['o']['fh'])) ? strip_tags($result['hotel']['o']['fh']) : NULL;
        $hotel['beach_description'] = (isset($result['hotel']['o']['b'])) ? strip_tags($result['hotel']['o']['b']) : NULL;

        $rating = [];
        foreach ($result['hotel']['vs'] as $k1 => $v1) {
            $rid = $this->hid . '_' . $k1;
            $body = [
                'rid' => $rid,
                'name' => $v1['name'],
                'vote' => number_format($v1['vote'], 13, '.', ''),
                'count' => strval($v1['count']),
            ];
            $rating[$rid] = $body;
        }
        $hotel['rating'] = $rating;

        $service = ArrayHelper::index(Service::find()->asArray()->all(), 'code');
        $data = [];
        if (isset($result['hotel']['e'])) {
            foreach ($result['hotel']['e'] as $k1 => $v1) {
                foreach ($v1 as $k2 => $v2) {
                    if (!isset($service[$k2]['id']))
                        continue;
                    $body = [
                        'hid' => strval($this->hid),
                        'service_id' => $service[$k2]['id'],
                        'type' => ($v2['id'] == 'pay') ? '1' : '0',
                    ];
                    $data[$service[$k2]['id']] = $body;
                }
            }
        }
        ksort($data);
        $hotel['service'] = $data;
        return $this->getHash($hotel);
    }

    private function getApiSearchData() {
        $data['hotelId'] = $this->hid;
        $data['access_token'] = Yii::$app->params['apiToken'];
        $body = [];
        for ($i = 0; $i < 10; $i++) {
            $curl = Curl::curl('GET', '/api/tours/hotel', $data);
            if ($curl['status'] === 200 && isset($curl['body'])) {
                if (is_array($curl['body']) && count($curl['body']) > 0 && !empty($curl['body']['hotel'])) {
                    $body = $curl['body'];
                    break;
                }
            }
            sleep(1);
        }
        $this->api_data = $body;
        return $body;
    }

    private function getHash($array) {
        return md5(json_encode($array));
    }
}