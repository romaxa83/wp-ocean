<?php

namespace console\controllers\api0;

use Yii;
use yii\helpers\Json;
use common\models\Curl;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\Country;
use yii\helpers\ArrayHelper;

class HotelController extends BaseController {

    public function actionIndex($id = NULL) {
        if (is_null($id)) {
            $country = Country::find()->select(['cid'])->asArray()->all();
        } else {
            $country = Country::find()->select(['cid'])->where(['in', 'cid', (explode(',', $id))])->asArray()->all();
        }
        $hotel = Hotel::find()->asArray()->all();
        $hotel = ArrayHelper::index($hotel, 'hid');
        $this->key = 'hid';
        $this->key_update = 'hid';
        $this->model = new Hotel();
        foreach ($country as $v) {
            $data = [];
            $curl = Curl::curl('GET', '/api/tours/hotels', ['countryId' => $v['cid'], 'with' => 'price', 'access_token' => Yii::$app->params['apiToken']]);
            if ($curl['status'] == 200) {
                foreach ($curl['body']['hotels'] as $v1) {
                    $body = [
                        'hid' => $v1['id'],
//                        'media_id' => NULL,
                        'country_id' => $v['cid'],
                        'city_id' => $v1['cityId'],
                        'category_id' => (int) $v1['stars'],
//                        'type_id' => 0,
//                        'view_id' => 0,
                        'name' => $v1['name'],
                        'alias' => $v1['code'],
//                        'gallery' => NULL,
//                        'status' => TRUE,
//                        'sync' => TRUE
                    ];
                    if (isset($hotel[$v1['id']])) {
                        $temp = array_diff_assoc($body, $hotel[$v1['id']]);
                        if (count($temp) > 0) {
                            $data['update'][$v1['id']] = $temp;
                        }
                    } else {
                        $data['insert'][] = $body;
                    }
                }
                $this->dataInsert($data);
                //$this->dataUpdate($data);
            }
        }
        $this->sendMessage('hotel');
    }

}
