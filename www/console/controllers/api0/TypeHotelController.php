<?php

namespace console\controllers\api0;

use Yii;
use yii\helpers\Json;
use common\models\Curl;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\TypeHotel;
use common\service\CacheService;

class TypeHotelController extends BaseController {

    public function actionIndex() {
        $data = [];
        $this->key = 'code';
        $this->key_update = 'code';
        $this->model = new TypeHotel();
        $hotel = TypeHotel::find()->asArray()->all();
        $hotel = ArrayHelper::index($hotel, 'code');
        $curl = Curl::curl('GET', '/api/tours/static', ['access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            foreach ($curl['body']['form'] as $k => $v) {
                $body = [
                    'code' => $k,
                    'name' => $v,
                    //'description' => NULL,
                    //'media_id' => NULL,
                    //'status' => 1,
                    //'sync' => 1
                ];
                if (isset($hotel[$k])) {
                    $temp = array_diff_assoc($body, $hotel[$k]);
                    if (count($temp) > 0) {
                        $data['update'][$k] = $temp;
                    }
                } else {
                    $data['insert'][] = $body;
                }
            }
            $this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage('type-hotel');
        }
    }

}
