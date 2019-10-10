<?php

namespace backend\modules\request\widgets\request;

use yii\base\Widget;
use backend\modules\request\models\Request;

class RequestWidget extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $request = new Request();
        return $this->render('request', [
                    'request' => $request
        ]);
    }

}
