<?php

namespace frontend\controllers\api;

use Yii;
use yii\web\Controller;
use frontend\components\Job;
use yii\helpers\Json;

class WhController extends Controller {

    public $enableCsrfValidation = false;
    private $token = '080042cad46356ad5sd5c0a720c18b53b8e5s653d4c274';
    private $limit = 250;

    public function actionIndex() {
        if (Yii::$app->request->isPost) {
            try {
                $auth = NULL;
                $headers = Yii::$app->request->headers;
                if (isset($headers['authorization'])) {
                    $auth = explode(' ', $headers['authorization'])[1];
                } else {
                    return Json::encode(['status' => 404, 'type' => 'error', 'message' => 'not valid method authorization']);
                }
                if ($this->token === $auth) {
                    if ($this->checkLimit()) {
                        $this->send(Yii::$app->request->post());
                        return Json::encode(['status' => 200, 'type' => 'success', 'message' => 'ok']);
                    } else {
                        Yii::$app->response->statusCode = 404;
                        return Json::encode(['status' => 404, 'type' => 'error', 'message' => 'daily request limit has been reached']);
                    }
                } else {
                    Yii::$app->response->statusCode = 404;
                    return Json::encode(['status' => 404, 'type' => 'error', 'message' => 'not valid authorization token']);
                }
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 500;
                return Json::encode(['status' => 500, 'type' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            Yii::$app->response->statusCode = 404;
            return Json::encode(['status' => 404, 'type' => 'error', 'message' => 'method GET not allowed']);
        }
    }

    private function checkLimit() {
        $date = date('Y-m-d');
        if (!Yii::$app->cache->exists($this->token)) {
            Yii::$app->cache->set($this->token, [$date => 0]);
        }
        $limit = Yii::$app->cache->get($this->token)[$date];
        $limit += 1;
        Yii::$app->cache->set($this->token, [$date => $limit]);
        if ($limit > $this->limit) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function send($post) {
        Yii::$app->queue->push(new Job(['post' => $post]));
    }

}
