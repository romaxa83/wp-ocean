<?php

namespace console\controllers\api0;

use Yii;
use backend\modules\referenceBooks\models\Operator;
use yii\helpers\ArrayHelper;
use common\models\Curl;
use yii\helpers\Json;

class OperatorController extends BaseController {

    public function actionIndex() {
        $data = [];
        $operator = ArrayHelper::index(Operator::find()->where(['sync' => TRUE])->asArray()->all(), 'oid');
        $this->key = 'oid';
        $this->key_update = 'oid';
        $this->model = new Operator();
        $curl = Curl::curl('GET', '/api/tours/operators', ['access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            foreach ($curl['body']['operators'] as $v) {
                $body = [
                    'oid' => $v['id'],
                    'name' => $v['name'],
                    'url' => $v['url'],
                    'countries' => Json::encode(array_keys($v['countries'])),
                    'currencies' => Json::encode($v['currencies']),
                    //'status' => TRUE,
                    //'sync' => TRUE
                ];
                if (isset($operator[$v['id']])) {
                    $temp = array_diff_assoc($body, $operator[$v['id']]);
                    (count($temp) > 0) ? $data['update'][$v['id']] = $temp : FALSE;
                } else {
                    $data['insert'][] = $body;
                }
            }
            $operator_keys = array_keys($operator);
            $operator_api_keys = array_keys($curl['body']['operators']);
            $temp = array_diff_assoc($operator_keys, $operator_api_keys);
            (count($temp) > 0) ? $data['delete'] = $temp : FALSE;
            $this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage($this->model->tableName());
        }
    }

}
