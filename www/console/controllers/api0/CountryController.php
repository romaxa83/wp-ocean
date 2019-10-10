<?php

namespace console\controllers\api0;

use Yii;
use common\models\Curl;
use backend\modules\referenceBooks\models\Country;
use yii\helpers\ArrayHelper;

class CountryController extends BaseController {

    public function actionIndex() {
        $data = [];
        $this->key = 'cid';
        $this->key_update = 'cid';
        $this->model = new Country();
        $country = Country::find()->where(['sync' => TRUE])->asArray()->all();
        $country = ArrayHelper::index($country, 'cid');
        $curl = Curl::curl('GET', '/api/tours/countries', ['with' => 'price', 'access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            foreach ($curl['body']['countries'] as $v) {
                $body = [
                    //'media_id' => NULL,
                    'cid' => $v['id'],
                    //'code' => $v['code'],
                    'name' => $v['name'],
                    'nameVn' => $v['nameVn'],
                    //'alias' => mb_strtolower($v['code']),
                    //'country_description' => NULL,
                    //'doc_description' => NULL,
                    //'visa_description' => NULL,
                    'lat' => sprintf("%01.13f", $v['lat']),
                    'lng' => sprintf("%01.13f", $v['lng']),
                    'zoom' => $v['zoom'],
                    'visa' => ($v['visa'] === 'no') ? 1 : 0,
//                    'status' => 1,
//                    'sync' => 1
                ];
                if (isset($country[$v['id']])) {
                    $temp = array_diff_assoc($body, $country[$v['id']]);
                    if (count($temp) > 0) {
                        $data['update'][$v['id']] = $temp;
                    }
                } else {
                    $data['insert'][] = $body;
                }
            }
            //$this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage('country');
        }
    }

}
