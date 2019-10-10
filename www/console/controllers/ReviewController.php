<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use console\controllers\SimpleHTMLDom;
use backend\modules\referenceBooks\models\HotelReview;
use backend\modules\referenceBooks\models\Hotel;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ReviewController extends Controller {

    public $host = 'https://www.turpravda.com';
    public $cookie = '@backend/cookie/cookie.txt';
    public $otpusk = 'https://www.otpusk.com/hotel/';
    private $lockFile = '@console/runtime/ReviewController.lock';

    public function actionParse($id = NULL) {
        $this->createLockFile();
        if ((boolean) $this->checkLockFile()) {
            return TRUE;
        }
        $this->lockFile();
        $reviews = [];
        if ($id == NULL) {
            $limit = 1;
            if (!Yii::$app->cache->exists('review_offset')) {
                Yii::$app->cache->set('review_offset', 0);
            }
            $offset = Yii::$app->cache->get('review_offset');
            $hotel = Hotel::find()->select(['id', 'hid', 'alias'])->asArray()->limit($limit)->offset($offset)->one();
        } else {
            $hotel = Hotel::find()->select(['id', 'hid', 'alias'])->asArray()->where(['id' => $id])->one();
        }
        $hotel_review = HotelReview::find()->where(['hotel_id' => $hotel['id']])->asArray()->all();
        $hotel_review = ArrayHelper::index($hotel_review, 'rid');
        $hotels_count = Hotel::find()->count();
        $data = SimpleHTMLDom::file_curl_get_html($this->otpusk . $hotel['hid'] . '-' . $hotel['alias'], 0, 30, $this->cookie);
        $link = $data->find('div[class="inf-add-info"] a')[0]->href;
        $count_review = (int) $data->find('div[class="inf-add-info"] a')[0]->plaintext;
        $data->clear();
        unset($data);
        if ($count_review == 0) {
            Yii::$app->telegram->sendMessage([
                'chat_id' => '396140135',
                'text' => 'review: ' . Json::encode([
                    'hid' => $hotel['hid'],
                    'data' => 'Нет данных',
                ]) . ': Метод обработан за ' . sprintf('%0.5f', Yii::getLogger()->getElapsedTime()) . 'с.',
            ]);
            if ($id == NULL)
                ($offset > $hotels_count) ? Yii::$app->cache->set('review_offset', 0) : Yii::$app->cache->set('review_offset', ($offset + $limit));
            $this->unlockFile();
            exit();
        }
        $data = SimpleHTMLDom::file_curl_get_html($link, 0, 30, $this->cookie);
        foreach ($data->find('div[class="ans_block"]') as $block) {
            $reviews[] = $this->getReview($block, $hotel);
        }
        foreach ($data->find('div[id="PagerBefore"] a') as $a) {
            $data_pager = SimpleHTMLDom::file_curl_get_html($this->host . $a->href, 0, 30, $this->cookie);
            foreach ($data_pager->find('div[class="ans_block"]') as $block) {
                $reviews[] = $this->getReview($block, $hotel);
            }
            $data_pager->clear();
            unset($data_pager);
        }
        $data->clear();
        unset($data);
        $data = [];
        foreach ($reviews as $k => $v) {
            if (isset($hotel_review[$v['rid']])) {
                $temp = array_diff_assoc($v, $hotel_review[$v['rid']]);
                if (count($temp) > 0) {
                    $data['update'][$v['rid']] = $temp;
                }
            } else {
                $data['insert'][] = $v;
            }
        }
        
        (isset($data['insert'])) ? $this->insertReview(array_unique($data['insert'], SORT_REGULAR)) : FALSE;
        (isset($data['update'])) ? $this->updateReview(array_unique($data['update'], SORT_REGULAR)) : FALSE;
        if ($id == NULL) {
            Yii::$app->telegram->sendMessage([
                'chat_id' => '396140135',
                'text' => 'review: ' . Json::encode([
                    'hid' => $hotel['hid'],
                    'limit' => $limit,
                    'offset' => $offset
                ]) . ': Метод обработан за ' . sprintf('%0.5f', Yii::getLogger()->getElapsedTime()) . 'с.',
            ]);
            ($offset > $hotels_count) ? Yii::$app->cache->set('review_offset', 0) : Yii::$app->cache->set('review_offset', ($offset + $limit));
        } else {
            Yii::$app->telegram->sendMessage([
                'chat_id' => '396140135',
                'text' => 'review: ' . Json::encode([
                    'hid' => $hotel['hid'],
                ]) . ': Метод обработан за ' . sprintf('%0.5f', Yii::getLogger()->getElapsedTime()) . 'с.',
            ]);
        }
        $this->unlockFile();
    }

    private function getReview($block, $hotel) {
        $data_id = 'data-id';
        return [
            'hotel_id' => $hotel['id'],
            'rid' => $block->find('div[class="comments-container"]')[0]->$data_id,
            'date' => (isset($block->find('div[class="new-rev-info"] span[title]')[0]->title)) ? Yii::$app->formatter->asDate(preg_replace("/[^0-9.]/", '', $block->find('div[class="new-rev-info"] span[title]')[0]->title), 'php:Y-m-d 00:00:00') : NULL,
            'user' => (isset($block->find('a[class="userInfo"] span[itemprop="name"]')[0]->plaintext)) ? trim($block->find('a[class="userInfo"] span[itemprop="name"]')[0]->plaintext) : NULL,
            'avatar' => trim($this->host . $block->find('div[class="ans_avatar"] img')[0]->src),
            'title' => trim($block->find('div[class="rev-title-wrap"] a')[0]->plaintext),
            'comment' => mb_convert_encoding((substr(trim($block->find('span[class="all-text"]')[0]->plaintext), 0, 65534)), 'UTF8'),
            'vote' => (isset($block->find('div[class="vote"] span[class="value"] b')[0]->plaintext)) ? (int) $block->find('div[class="vote"] span[class="value"] b')[0]->plaintext : 0,
            'status' => TRUE,
            'user_id' => NULL
        ];
    }

    private function insertReview($data) {
        Yii::$app->db->createCommand()->batchInsert('hotel_review', $this->getList(), $data)->execute();
    }

    private function updateReview($data) {
        $update = [];
        foreach ($data as $k => $v) {
            foreach ($v as $k1 => $v1) {
                if (array_search($k1, $this->getList()) !== FALSE) {
                    $update[$k1][] = " WHEN `rid` = '" . $k . "' THEN '" . $v1 . "'";
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
                Yii::$app->db->createCommand("UPDATE `hotel_review` SET " . (implode(',', $update_data)) . ";")->execute();
            }
        }
    }

    private function getList() {
        $model = new HotelReview();
        $list = array_keys($model->getAttributes());
        if ($list[0] == 'id') {
            unset($list[0]);
        }
        return $list;
    }

    private function createLockFile() {
        if (!file_exists(Yii::getAlias($this->lockFile))) {
            $fp = fopen(Yii::getAlias($this->lockFile), 'w+');
            fclose($fp);
        }
    }

    private function lockFile() {
        $fp = fopen(Yii::getAlias($this->lockFile), 'w+');
        fwrite($fp, 1);
        fclose($fp);
    }

    private function unlockFile() {
        $fp = fopen(Yii::getAlias($this->lockFile), 'w+');
        fwrite($fp, 0);
        fclose($fp);
    }

    private function checkLockFile() {
        return file_get_contents(Yii::getAlias($this->lockFile));
    }

}
