<?php

namespace console\controllers\api0;

use Yii;
use common\models\Curl;
use yii\helpers\ArrayHelper;
use backend\modules\referenceBooks\models\Transport;

class TypeTransportController extends BaseController {

    public function actionIndex() {
        $data = [];
        $this->key = 'code';
        $this->key_update = 'code';
        $this->model = new Transport();
        $transport = Transport::find()->asArray()->all();
        $transport = ArrayHelper::index($transport, 'code');
        $curl = Curl::curl('GET', '/api/tours/static', ['access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            foreach ($curl['body']['transport'] as $k => $v) {
                $body = [
                    'code' => $k,
                    'name' => $v,
                    //'status' => 1,
                    //'sync' => 1
                ];
                if (isset($transport[$k])) {
                    $temp = array_diff_assoc($body, $transport[$k]);
                    if (count($temp) > 0) {
                        $data['update'][$k] = $temp;
                    }
                } else {
                    $data['insert'][] = $body;
                }
            }
            $this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage('type-transport');
        }
    }

}
