<?php

namespace console\controllers\api0;

use Yii;
use common\models\Curl;
use backend\modules\referenceBooks\models\City;
use backend\modules\referenceBooks\models\Country;
use yii\helpers\ArrayHelper;

class CityController extends BaseController {

    public function actionIndex($id = NULL) {
        $this->key = 'cid';
        $this->key_update = 'cid';
        $this->model = new City();
        if (is_null($id)) {
            $country = Country::find()->select(['cid'])->asArray()->all();
        } else {
            $country = Country::find()->select(['cid'])->where(['in', 'cid', (explode(',', $id))])->asArray()->all();
        }
        //$city = City::find()->where(['sync' => TRUE])->asArray()->all();
        $city = City::find()->asArray()->all();
        $city = ArrayHelper::index($city, 'cid');
        foreach ($country as $item) {
            $data = [];
            $curl = Curl::curl('GET', '/api/tours/cities', ['countryId' => $item['cid'], 'access_token' => Yii::$app->params['apiToken']]);
            if ($curl['status'] == 200) {
                foreach ($curl['body']['cities'] as $v) {
                    $body = [
                        'country_id' => $item['cid'],
                        'cid' => $v['id'],
                        //'code' => $v['code'],
                        'name' => addslashes($v['name']),
                        'nameVn' => addslashes($v['nameVn']),
                        //'alias' => mb_strtolower($v['code']),
                        'lat' => sprintf("%01.13f", $v['lat']),
                        'lng' => sprintf("%01.13f", $v['lng']),
                        'zoom' => $v['zoom'],
                    ];
                    if (isset($city[$v['id']])) {
                        $temp = array_diff_assoc($body, $city[$v['id']]);
                        if (count($temp) > 0) {
                            $data['update'][$v['id']] = $temp;
                        }
                    } else {
                        $data['insert'][] = $body;
                    }
                }
                //$this->dataInsert($data);
                $this->dataUpdate($data);
            }
        }
        $this->sendMessage('city');
    }

}
