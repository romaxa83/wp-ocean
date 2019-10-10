<?php

namespace console\controllers\api0;

use Yii;
use common\models\Curl;
use backend\modules\referenceBooks\models\Service;

class TypeServiceController extends BaseController {

    public function actionIndex() {
        $this->key = 'code';
        $this->key_update = 'code';
        $this->model = new Service();
        $cache = $this->model->tableName();
        $curl = Curl::curl('GET', '/api/tours/services', ['access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            $data = [];
            $service_data = [];
            $service_data_code = [];
            $list = ['mainService', 'childService', 'sportService', 'beachService', 'promoService', 'recommendService', 'roomService'];
            $service = Service::find()->asArray()->all();
            foreach ($service as $k => $v) {
                $service_data[$v['type']][$v['code']] = $v;
                $service_data_code[$v['type']][$v['code']] = $v['name'];
            }
            foreach ($list as $v) {
                foreach ($curl['body'][$v] as $k1 => $v1) {
                    $body = [
                        'code' => $k1,
                        'name' => $v1,
                        'type' => $v,
//                        'status' => 1,
//                        'sync' => 1
                    ];
                    if (isset($service_data[$v][$k1])) {
                        $temp = array_diff_assoc($body, $service_data[$v][$k1]);
                        (count($temp) > 0) ? $data['update'][$k1] = $temp : FALSE;
                    } else {
                        $data['insert'][] = $body;
                    }
                }
                if (isset($service_data_code[$v])) {
                    $temp = array_diff_assoc($service_data_code[$v], $curl['body'][$v]);
                    (count($temp) > 0) ? $data['delete'] = key($temp) : FALSE;
                }
            }
            $this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage($cache);
        }
    }

}
