<?php

namespace common\service;

use Yii;
use yii\helpers\Json;
use backend\models\Hash;

class CacheService {

    public $id;
    public $key;
    public $model;
    public $cache;

    private function setHash($data) {
        $hash = Hash::find()->where(['cache' => $this->cache])->one();
        if ($hash === NULL)
            $hash = new Hash();
        $hash->api_id = 0;
        $hash->hash = sha1($data);
        $hash->cache = $this->cache;
        $hash->save();
    }

//    public function renderAll() {
//        $data = Json::encode($this->model::find()->asArray()->all());
//        $this->setHash($data);
//        Yii::$app->cache->set($this->cache, $data);
//    }

    public function render($where = []) {
        $data = $this->model::find()->asArray()->where($where)->all();
//        var_dump($data); exit();
//        if ($data !== NULL) {
//            $cdata = Json::decode(Yii::$app->cache->get($this->cache));
//            foreach ($cdata as $k => $v) {
//                if ($v[$this->key] == $data[$this->key]) {
//                    $cdata[$k] = $data;
//                    break;
//                }
//            }
//        }
        if ($data === NULL) {
            $data = [];
        }
        $data = Json::encode($data);
        $this->setHash($data);
        Yii::$app->cache->set($this->cache, $data);
    }

}
