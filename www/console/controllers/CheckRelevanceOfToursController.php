<?php


namespace console\controllers;


use backend\modules\referenceBooks\models\Tour;
use backend\modules\specials\models\Special;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class CheckRelevanceOfToursController extends Controller {
    private $tours;

    public function actionCheck() {
        $this->turnOffTours();
        $this->recountTours();
        $this->turnOffSpecials();
    }

    public function recountTours() {
        $this->tours = ArrayHelper::index(Tour::find()->select(['id', 'main', 'recommend', 'hot'])->filterWhere(['or',
            ['>', 'main', 0],
            ['>', 'recommend', 0],
            ['>', 'hot', 0]])->asArray()->all(), 'id');

        $this->recountPositions($this->tours, 'main');
        $this->recountPositions($this->tours, 'recommend');
        $this->recountPositions($this->tours, 'hot');

        foreach ($this->tours as $k => $v) {
            $tour = Tour::find()->where(['id' => $k])->one();
            $tour->main = $v['main'];
            $tour->recommend = $v['recommend'];
            $tour->hot = $v['hot'];
            $tour->save();
        }

    }

    private function recountPositions($data, $field) {
        $map = ArrayHelper::map($data, 'id', $field);
        asort($map);
        $temp = 1;
        foreach ($map as $k => $v) {
            if (isset($v) && !empty($v) && boolval($v)){
                $this->tours[$k][$field] = $temp;
                $temp++;
            }
        }
    }

    public static function turnOffTours() {
        $turn_off_tours = Tour::find()->where(['or',
            ['>', 'status', 0],
            ['>', 'main', 0],
            ['>', 'recommend', 0],
            ['>', 'hot', 0]])->andWhere(['<', 'date_departure', date("Y-m-d H:i:s")])->all();

        foreach ($turn_off_tours as $t) {
            $t->status = 0;
            $t->main = 0;
            $t->recommend = 0;
            $t->hot = 0;
            $t->exotic_page = 0;
            $t->hot_page = 0;
            $t->sale_page = 0;
            $t->save();
        }
    }

    public static function turnOffSpecials() {
        $turn_off_specials = Special::find()->where(['status' => '1'])->andWhere(
            ['<', 'to_datetime', date("Y-m-d H:i:s")])->all();

        foreach ($turn_off_specials as $s) {
            $s->status = 0;
            $s->save();
        }
    }
}
