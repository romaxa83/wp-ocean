<?php

namespace console\controllers\api0;

use Yii;
use backend\models\Hash;
use yii\console\Controller;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\service\CacheService;

class BaseController extends Controller {

    public $key;
    public $key_update;
    public $hash;
    public $model;
    public $list;

    public function checkHash() {
        $flag = FALSE;
        $hash = $this->getHash();
        if ($hash === NULL) {
            $this->setHash();
            $flag = TRUE;
        } else {
            if ($hash != $this->hash) {
                $flag = TRUE;
            }
        }
        return $flag;
    }

    public function getHash() {
        $hash = Hash::find()->asArray()->select('hash')->where(['cache' => $this->model->tableName()])->one();
        return $hash;
    }

    public function setHash() {
        $hash = Hash::find()->where(['cache' => $this->model->tableName()])->one();
        if ($hash === NULL) {
            $hash = new Hash();
        }
        $hash->api_id = 0;
        $hash->hash = $this->hash;
        $hash->cache = $this->model->tableName();
        $hash->save();
    }

    public function dataDelete($data) {
        if (isset($data['delete']) && count($data['delete']) > 0) {
            Yii::$app->db->createCommand()->delete($this->model->tableName(), [$this->key => $data['delete'], 'sync' => TRUE])->execute();
        }
    }

    public function dataInsert($data) {
        if (isset($data['insert']) && count($data['insert']) > 0) {
            Yii::$app->db->createCommand()->batchInsert($this->model->tableName(), array_keys($data['insert'][0]), $data['insert'])->execute();
        }
    }

    private function multiDiff($data_1, $data_2, $result = []) {
        foreach ($data_1 as $k => $v) {
            if (is_array($v)) {
                if (isset($data_2[$k])) {
                    $result = $this->multiDiff($v, $data_2[$k], $result);
                } else {
                    $result['insert'][$v[$this->key]] = $v;
                }
            } else {
                if (isset($data_2[$k]) && $v != $data_2[$k]) {
                    $result['update'][$data_2[$this->key]][$k] = $v;
                }
            }
        }
        return $result;
    }

    public function getDiff($data_1, $data_2) {
        $result = [];
        $data_hash_1 = sha1($data_1);
        $data_hash_2 = sha1($data_2);
        if ($data_hash_1 !== $data_hash_2) {
            $data_1 = Json::decode($data_1);
            $data_2 = Json::decode($data_2);
            $data_1 = ArrayHelper::index($data_1, $this->key);
            $data_2 = ArrayHelper::index($data_2, $this->key);
            $result = $this->multiDiff($data_1, $data_2);
            (!isset($result['insert'])) ? $result['insert'] = [] : FALSE;
            $result['delete'] = array_keys(array_diff_key($data_2, $data_1));
        }
        return $result;
    }

    public function dataUpdate($data) {
        if (isset($data['update']) && count($data['update']) > 0) {
            $update = [];
            foreach ($data['update'] as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    if (array_search($k1, $this->getList()) !== FALSE) {
                        $update[$k1][] = " WHEN `" . $this->key_update . "` = '" . $k . "' THEN '" . $v1 . "'";
                    }
                }
            }
            if (count($update) > 0) {
                $update_data = [];
                foreach ($this->getList() as $v) {
                    if (isset($update[$v])) {
                        $update_data[] = "`" . $v . "` = CASE " . (implode('', $update[$v])) . " ELSE `" . $v . "` END";
                    }
                }
                if (count($update_data) > 0) {
                    Yii::$app->db->createCommand("UPDATE `" . $this->model->tableName() . "` SET " . (implode(',', $update_data)) . ";")->execute();
                }
            }
        }
    }

    public function getList() {
        $list = array_keys($this->model->getAttributes());
        if ($list[0] == 'id')
            unset($list[0]);
        return $list;
    }

    public function renderCache($cache, $id = NULL) {
        $service = new CacheService($cache, $id);
        $service->model = $this->model;
        $service->key = $this->key;
        $service->render();
    }

    protected function sendMessage($action) {
        Yii::$app->telegram->sendMessage([
            'chat_id' => '396140135',
            'text' => $action . ': Метод обработан за ' . sprintf('%0.5f', Yii::getLogger()->getElapsedTime()) . 'с.',
        ]);
    }

}
