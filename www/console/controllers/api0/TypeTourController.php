<?php

namespace console\controllers\api0;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Curl;
use backend\modules\referenceBooks\models\TypeTour;

class TypeTourController extends BaseController {

    public function actionIndex() {
        $data = [];
        $this->key = 'code';
        $this->key_update = 'code';
        $this->model = new TypeTour();
        $tour = TypeTour::find()->asArray()->all();
        $tour = ArrayHelper::index($tour, 'code');
        $curl = Curl::curl('GET', '/api/tours/static', ['access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            foreach ($curl['body']['cat'] as $k => $v) {
                $body = [
                    'code' => $k,
                    'name' => $v,
                    //'description' => NULL,
                    //'media_id' => NULL,
                    //'status' => 1,
                    //'sync' => 1
                ];
                if (isset($tour[$k])) {
                    $temp = array_diff_assoc($body, $tour[$k]);
                    if (count($temp) > 0) {
                        $data['update'][$k] = $temp;
                    }
                } else {
                    $data['insert'][] = $body;
                }
            }
            $this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage('type-tour');
        }
    }

}
