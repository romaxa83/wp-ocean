<?php

namespace console\controllers\api0;

use Yii;
use common\models\Curl;
use backend\modules\referenceBooks\models\Offer;
use yii\helpers\ArrayHelper;

class OfferController extends BaseController {

    public function actionIndex() {
        $curl = Curl::curl('GET', '/api/tours/search', ['deptCity' => 1544, 'to' => 11243, 'checkIn' => '2019-01-07', 'access_token' => Yii::$app->params['apiToken']]);
        if ($curl['status'] == 200) {
            if ($curl['body']['lastResult'] == true) {
                var_dump(count($curl['body']['hotels'][1][11243]['offers']));
                var_dump($curl['body']['hotels']);
            }
        }
    }

}
