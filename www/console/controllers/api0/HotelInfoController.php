<?php

namespace console\controllers\api0;

use Yii;
use yii\helpers\Json;
use common\models\Curl;
use yii\imagine\Image;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\TypeTour;
use backend\modules\referenceBooks\models\TypeHotel;
use backend\modules\referenceBooks\models\Service;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\referenceBooks\models\Address;
use backend\modules\referenceBooks\models\Rating;
use backend\modules\referenceBooks\models\HotelService;
use yii\helpers\ArrayHelper;
use common\service\ProxyService;

class HotelInfoController extends BaseController {

    public function actionIndex($id = NULL) {
        $log = [];
        if ($id === NULL) {
            $limit = 50;
            if (!Yii::$app->cache->exists('hotel_offset')) {
                Yii::$app->cache->set('hotel_offset', 0);
            }
            $offset = Yii::$app->cache->get('hotel_offset');
            $hotels = Hotel::find()->select(['id', 'media_id', 'hid', 'view_id', 'type_id', 'gallery'])->where(['sync' => TRUE])->with('hS')->with('address')->with('rating')->limit($limit)->offset($offset)->asArray()->all();
        } else {
            $id = explode(',', $id);
            $hotels = Hotel::find()->select(['id', 'media_id', 'hid', 'view_id', 'type_id', 'gallery'])->where(['sync' => TRUE])->andWhere(['in', 'id', $id])->with('hS')->with('address')->with('rating')->asArray()->all();
        }
        $data = [];
        $type_tour = ArrayHelper::index(TypeTour::find()->asArray()->all(), 'code');
        $type_hotel = ArrayHelper::index(TypeHotel::find()->asArray()->all(), 'code');
        $service = ArrayHelper::index(Service::find()->asArray()->all(), 'code');
        $hotels_count = Hotel::find()->where(['sync' => TRUE])->count();
        foreach ($hotels as $v) {
            var_dump($v['hid']);
            $log[] = $v['hid'];
            $curl = Curl::curl('GET', '/api/tours/hotel', ['hotelId' => $v['hid'], 'access_token' => Yii::$app->params['apiToken']]);
            if ($curl['status'] == 200) {

                //Address update insert
                $address = $this->getAddress($v, $curl);
                if (isset($v['address']['id'])) {
                    $tmp = array_diff_assoc($address, $v['address']);
                    if (count($tmp) > 0) {
                        $data['address']['update'][$v['hid']] = $tmp;
                    }
                } else {
                    $data['address']['insert'][$v['hid']] = $address;
                }

                //Rating update delete insert
                $rating = $this->getRating($v, $curl);
                $v['rating'] = ArrayHelper::index($v['rating'], 'rid');
                foreach ($rating as $key => $item) {
                    if (isset($v['rating'][$key])) {
                        $tmp = array_diff_assoc($item, $v['rating'][$key]);
                        if (count($tmp) > 0) {
                            $data['rating']['update'][$v['hid']][$key] = $tmp;
                        }
                    } else {
                        $data['rating']['insert'][$v['hid']][$key] = $item;
                    }
                }

                //Hotel update
                $hotel = $this->getHotel($v, $curl, $type_tour, $type_hotel);
                $tmp = array_diff_assoc($hotel, $v);
                if (count($tmp) > 0) {
                    $data['hotel']['update'][$v['hid']] = $tmp;
                }

                //HotelService update insert
                $hotel_service = $this->getHotelService($v, $curl, $service);
                $v['hS'] = ArrayHelper::index($v['hS'], 'service_id');
                foreach ($hotel_service as $key => $item) {
                    if (isset($v['hS'][$key])) {
                        $tmp = array_diff_assoc($item, $v['hS'][$key]);
                        if (count($tmp) > 0) {
                            $data['hotel_service']['update'][$v['hid']][$key] = $tmp;
                        }
                    } else {
                        $data['hotel_service']['insert'][$v['hid']][$key] = $item;
                    }
                }
            }
        }
        $this->insertHotel($data);
        $this->updateHotel($data);
        if ($id === NULL) {
            $this->sendMessage('hotel: ' . Json::encode([
                        'limit' => $limit,
                        'offset' => $offset,
                        'hotel' => $log,
            ]));
            ($offset >= $hotels_count) ? Yii::$app->cache->set('hotel_offset', 0) : Yii::$app->cache->set('hotel_offset', ($offset + $limit));
        } else {
            $this->sendMessage('hotel: ' . Json::encode([
                        'hid' => $id,
                        'hotel' => $log,
            ]));
        }
    }

    private function getAddress($v, $curl) {
        $body = [
            'hotel_id' => $v['id'],
            'hid' => $v['hid'],
            'address' => (isset($curl['body']['hotel']['ad']['a'])) ? strip_tags($curl['body']['hotel']['ad']['a']) : NULL,
            'phone' => (isset($curl['body']['hotel']['ad']['ph'])) ? strip_tags($curl['body']['hotel']['ad']['ph']) : NULL,
            'email' => (isset($curl['body']['hotel']['ad']['ml'])) ? strip_tags($curl['body']['hotel']['ad']['ml']) : NULL,
            'site' => (isset($curl['body']['hotel']['ad']['u'])) ? strip_tags($curl['body']['hotel']['ad']['u']) : NULL,
            'data_source' => '',
            'lat' => (isset($curl['body']['hotel']['g']['a'])) ? strip_tags($curl['body']['hotel']['g']['a']) : NULL,
            'lng' => (isset($curl['body']['hotel']['g']['o'])) ? strip_tags($curl['body']['hotel']['g']['o']) : NULL,
            'zoom' => (isset($curl['body']['hotel']['g']['z'])) ? strip_tags($curl['body']['hotel']['g']['z']) : NULL,
            'location' => '0',
            'general_description' => (isset($curl['body']['hotel']['o']['dc'])) ? strip_tags($curl['body']['hotel']['o']['dc']) : NULL,
            'location_description' => (isset($curl['body']['hotel']['o']['di'])) ? strip_tags($curl['body']['hotel']['o']['di']) : NULL,
            'food_description' => (isset($curl['body']['hotel']['o']['fh'])) ? strip_tags($curl['body']['hotel']['o']['fh']) : NULL,
            'distance_sea' => '',
            'beach_type' => '0',
            'beach_description' => (isset($curl['body']['hotel']['o']['b'])) ? strip_tags($curl['body']['hotel']['o']['b']) : NULL,
            'location_animals' => '0',
            'additional_information' => '',
            'sync' => '1'
        ];
        return $body;
    }

    private function getRating($v, $curl) {
        $data = [];
        foreach ($curl['body']['hotel']['vs'] as $k1 => $v1) {
            $rid = $v['hid'] . '_' . $k1;
            $body = [
                'hotel_id' => $v['hid'],
                'rid' => $rid,
                'name' => $v1['name'],
                'vote' => number_format($v1['vote'], 13, '.', ''),
                'count' => $v1['count'],
                'status' => TRUE,
                'sync' => TRUE
            ];
            $data[$rid] = $body;
        }
        return $data;
    }

    private function getHotel($v, $curl, $type_tour, $type_hotel) {
        $gallery = $this->getGallery($v, $curl);
        $body = [
            'media_id' => (isset($gallery[0])) ? $gallery[0] : NULL,
            'hid' => $v['hid'],
            'view_id' => $type_tour[$curl['body']['hotel']['tp']['i']]['id'],
            'type_id' => $type_hotel[$curl['body']['hotel']['fm']['i']]['id'],
            'gallery' => Json::encode($gallery)
        ];
        return $body;
    }

    private function getHotelService($v, $curl, $service) {
        $data = [];
        if (isset($curl['body']['hotel']['e'])) {
            foreach ($curl['body']['hotel']['e'] as $k1 => $v1) {
                foreach ($v1 as $k2 => $v2) {
                    if (!isset($service[$k2]['id']))
                        continue;
                    $body = [
                        'hotel_id' => $v['id'],
                        'hid' => $v['hid'],
                        'service_id' => $service[$k2]['id'],
                        'type' => ($v2['id'] == 'pay') ? 1 : 0,
                        'price' => '0.0000000000000',
                        'sync' => 1
                    ];
                    $data[$service[$k2]['id']] = $body;
                }
            }
        }
        return $data;
    }

    private function getGallery($v, $curl) {
        $media = [];
        $gallery = [];
        $link = 'https://newimg.otpusk.com/3/800x600/';
        $year = date('Y', time());
        $month = date('m', time());
        $path = Yii::getAlias('@backend') . "/web/uploads/$year/$month/hotels/";
        $path_upload = "uploads/$year/$month/hotels/";
        if ($v['gallery']) {
            $media_data = Mediafile::find()->asArray()->select(['id', 'SUBSTR(`url`, 24) AS `filename`'])->where(['in', 'id', Json::decode($v['gallery'])])->all();
            $media = ArrayHelper::map($media_data, 'id', 'filename');
            $insert = array_diff($curl['body']['hotel']['f'], $media);
        } else {
            $insert = $curl['body']['hotel']['f'];
        }
        $insert = $curl['body']['hotel']['f'];
        foreach ($insert as $v1) {
            $file = $link . $v1;
            $info = pathinfo($file);
            $photel = str_replace($info['basename'], '', $v1);
            $path_hotel = $path . $photel;
            if (!file_exists($path_hotel)) {
                mkdir($path_hotel, 0777, true);
            }
            if (Yii::$app->params['proxy_enable']) {
                for ($i = 0; $i < 10; $i++) {
                    if (@copy($file . '+', $path_hotel . $info['basename'], stream_context_create([
                                'http' => [
                                    'method' => "GET",
                                    'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n",
                                    'proxy' => ProxyService::getProxy(),
                                    'request_fulluri' => true
                ]]))) {
                        break;
                    }
                }
            } else {
                @copy($file . '+', $path_hotel . $info['basename']);
                if ($size = @getimagesize($path_hotel . $info['basename'])) {
                    if (!isset($size['bits']) || !isset($size['mime'])) {
                        $this->sendMessage('hotel-error: ' . Json::encode([
                                    'file' => $file,
                                    'hid' => $v['hid']
                        ]));
                        continue;
                    }
                    if ($size['bits'] == 24 && $size['mime'] == 'image/x-ms-bmp') {
                        $this->sendMessage('hotel-error: ' . Json::encode([
                                    'file' => $file,
                                    'hid' => $v['hid']
                        ]));
                        continue;
                    }
                    if (!isset($size['bits']) && $mime != 'image/x-ms-bmp') {
                        @copy($file, $path_hotel . $info['basename']);
                    }
                }
            }
            Image::thumbnail($path_hotel . $info['basename'], 128, 128)->save($path_hotel . $info['filename'] . '-fm.' . $info['extension'], ['quality' => 80]);
            $files[] = [
                'filename' => $info['basename'],
                'type' => mime_content_type($path_hotel . $info['basename']),
                'url' => $path_upload . $photel . $info['basename'],
                'alt' => NULL,
                'size' => filesize($path_hotel . $info['basename']),
                'description' => NULL,
                'thumbs' => NULL,
                'created_at' => time(),
                'updated_at' => NULL,
            ];
        }
        if (isset($files) && count($files) > 0) {
            Yii::$app->db->createCommand()->batchInsert('filemanager_mediafile', array_keys($files[0]), $files)->execute();
            foreach (range(Yii::$app->db->lastInsertID, (Yii::$app->db->lastInsertID + count($files) - 1)) as $number) {
                $gallery[] = $number;
            }
        } else {
            $gallery = array_keys($media);
        }
        return $gallery;
    }

    private function insertHotel($data) {
        if (isset($data['address']['insert'])) {
            $address = new Address();
            $list = array_keys($address->getAttributes());
            unset($list[0]);
            Yii::$app->db->createCommand()->batchInsert($address->tableName(), $list, $data['address']['insert'])->execute();
        }
        if (isset($data['rating']['insert'])) {
            $rating = new Rating();
            $list = array_keys($rating->getAttributes());
            unset($list[0]);
            foreach ($data['rating']['insert'] as $item) {
                Yii::$app->db->createCommand()->batchInsert($rating->tableName(), $list, $item)->execute();
            }
        }
        if (isset($data['hotel_service']['insert'])) {
            $hotel_service = new HotelService();
            $list = array_keys($hotel_service->getAttributes());
            foreach ($data['hotel_service']['insert'] as $item) {
                Yii::$app->db->createCommand()->batchInsert($hotel_service->tableName(), $list, $item)->execute();
            }
        }
    }

    private function updateHotel($data) {
        if (isset($data['address']['update'])) {
            $update = [];
            $address = new Address();
            $list = array_keys($address->getAttributes());
            unset($list[0]);
            foreach ($data['address']['update'] as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    if (array_search($k1, $list) !== FALSE) {
                        $update[$k1][] = " WHEN `hid` = '" . $k . "' THEN '" . $v1 . "'";
                    }
                }
            }
            if (count($update) > 0) {
                $update_data = [];
                foreach ($list as $v) {
                    if (isset($update[$v])) {
                        $update_data[] = "`" . $v . "` = CASE " . (implode('', $update[$v])) . " ELSE `" . $v . "` END";
                    }
                }
                if (count($update_data) > 0) {
                    Yii::$app->db->createCommand("UPDATE `" . $address->tableName() . "` SET " . (implode(',', $update_data)) . " WHERE `sync` = 1;")->execute();
                }
            }
        }
        if (isset($data['rating']['update'])) {
            $update = [];
            $rating = new Rating();
            $list = array_keys($rating->getAttributes());
            unset($list[0]);
            foreach ($data['rating']['update'] as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v2) {
                        if (array_search($k2, $list) !== FALSE) {
                            $update[$k2][] = " WHEN `rid` = '" . $k1 . "' THEN '" . $v2 . "'";
                        }
                    }
                }
            }

            if (count($update) > 0) {
                $update_data = [];
                foreach ($list as $v) {
                    if (isset($update[$v])) {
                        $update_data[] = "`" . $v . "` = CASE " . (implode('', $update[$v])) . " ELSE `" . $v . "` END";
                    }
                }
                if (count($update_data) > 0) {
                    Yii::$app->db->createCommand("UPDATE `" . $rating->tableName() . "` SET " . (implode(',', $update_data)) . " WHERE `sync` = 1;")->execute();
                }
            }
        }
        if (isset($data['hotel']['update'])) {
            $update = [];
            $hotel = new Hotel();
            $list = array_keys($hotel->getAttributes());
            unset($list[0]);
            foreach ($data['hotel']['update'] as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    if (array_search($k1, $list) !== FALSE) {
                        $update[$k1][] = " WHEN `hid` = '" . $k . "' THEN '" . $v1 . "'";
                    }
                }
            }
            if (count($update) > 0) {
                $update_data = [];
                foreach ($list as $v) {
                    if (isset($update[$v])) {
                        $update_data[] = "`" . $v . "` = CASE " . (implode('', $update[$v])) . " ELSE `" . $v . "` END";
                    }
                }
                if (count($update_data) > 0) {
                    Yii::$app->db->createCommand("UPDATE `" . $hotel->tableName() . "` SET " . (implode(',', $update_data)) . " WHERE `sync` = 1;")->execute();
                }
            }
        }
        if (isset($data['hotel_service']['update'])) {
            $update = [];
            $hotel_service = new HotelService();
            $list = array_keys($hotel_service->getAttributes());
            unset($list[0]);
            foreach ($data['hotel_service']['update'] as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    foreach ($v1 as $k2 => $v2) {
                        if (array_search($k2, $list) !== FALSE) {
                            $update[$k2][] = " WHEN `hotel_id` = '" . $k . "' AND `service_id` = '" . $k1 . "' THEN '" . $v2 . "'";
                        }
                    }
                }
            }
            if (count($update) > 0) {
                $update_data = [];
                foreach ($list as $v) {
                    if (isset($update[$v])) {
                        $update_data[] = "`" . $v . "` = CASE " . (implode('', $update[$v])) . " ELSE `" . $v . "` END";
                    }
                }
                if (count($update_data) > 0) {
                    Yii::$app->db->createCommand("UPDATE `" . $hotel_service->tableName() . "` SET " . (implode(',', $update_data)) . " WHERE `sync` = 1;")->execute();
                }
            }
        }
    }

}
