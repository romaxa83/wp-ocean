<?php

namespace console\controllers\api0;

use Yii;
use backend\modules\referenceBooks\models\DeptCity;
use yii\helpers\ArrayHelper;
use common\models\Curl;
use Ausi\SlugGenerator\SlugGenerator;

class DeptCityController extends BaseController {

    public function actionIndex() {
        $data = [];
        $dept_city = ArrayHelper::index(DeptCity::find()->asArray()->all(), 'cid');
        $this->key = 'cid';
        $this->key_update = 'cid';
        $this->model = new DeptCity();
        $curl = Curl::curl('GET', '/api/tours/deptCities', ['access_token' => Yii::$app->params['apiToken']]);
        $generator = new SlugGenerator();
        if ($curl['status'] == 200) {
            foreach ($curl['body']['deptCities'] as $v) {
                $body = [
                    'cid' => $v['id'],
                    'alias' => $generator->generate($v['name'], ['delimiter' => '_']),
                    'name' => $v['name'],
                    'rel' => $v['rel']
                ];
                if (isset($dept_city[$v['id']])) {
                    $temp = array_diff_assoc($body, $dept_city[$v['id']]);
                    (count($temp) > 0) ? $data['update'][$v['id']] = $temp : FALSE;
                } else {
                    $data['insert'][] = $body;
                }
            }
            $dept_city_keys = array_keys($dept_city);
            $dept_city_api_keys = array_keys(ArrayHelper::index($curl['body']['deptCities'], 'id'));
            $temp = array_diff_assoc($dept_city_api_keys, $dept_city_keys);
            (count($temp) > 0) ? $data['delete'] = $temp : FALSE;
            $this->dataInsert($data);
            $this->dataUpdate($data);
            $this->sendMessage('dept-city');
        }
    }

}
