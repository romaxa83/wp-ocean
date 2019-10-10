<?php

namespace console\controllers\api0;

use Yii;
use common\models\Curl;
use backend\modules\referenceBooks\models\TypeFood;
use yii\helpers\ArrayHelper;

class TypeFoodController extends BaseController {

    public function actionIndex() {
        $data = [];
        $this->key = 'code';
        $this->key_update = 'code';
        $this->model = new TypeFood();
        $food = TypeFood::find()->asArray()->all();
        $food = ArrayHelper::index($food, 'code');
        $curl = Curl::curl('GET', '/api/tours/static', ['access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            foreach ($curl['body']['food'] as $k => $v) {
                $body = [
                    'code' => $k,
                    'name' => $v,
                    //'description' => NULL,
                    //'position' => NULL,
                    //'status' => 1,
                    //'sync' => 1
                ];
                if (isset($food[$k])) {
                    $temp = array_diff_assoc($body, $food[$k]);
                    if (count($temp) > 0) {
                        $data['update'][$k] = $temp;
                    }
                } else {
                    $data['insert'][] = $body;
                }
            }
            $this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage('type-food');
        }
    }

}
