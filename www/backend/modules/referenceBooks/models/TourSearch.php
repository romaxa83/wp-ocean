<?php

namespace backend\modules\referenceBooks\models;

use Yii;
use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\Tour;

class TourSearch extends Tour {

    public function rules() {
        return [
            [[
            'id', 'title', 'city_id', 'hotel_id', 'type_food_id', 'date_departure', 'date_arrival', 'length', 'dept_city_id', 'type_transport_id',
            'operator_id', 'sale', 'date_begin', 'date_end', 'date_end_sale', 'currency', 'old_price', 'promo_price', 'price', 'main', 'recommend', 'hot', 'exotic_page', 'hot_page', 'sale_page', 'status'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = Tour::find()
                ->joinWith('city.country')
                ->joinWith('hotel')
                ->joinWith('hotel.category')
                ->joinWith('food')
                ->joinWith('deptCity')
                ->joinWith('transport')
                ->joinWith('operator');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => $page,
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $date_departure = (!empty($this->date_departure)) ? Yii::$app->formatter->asDate($this->date_departure, 'php:Y-m-d') : $this->date_departure;
        $date_arrival = (!empty($this->date_arrival)) ? Yii::$app->formatter->asDate($this->date_arrival, 'php:Y-m-d') : $this->date_arrival;
        $date_begin = (!empty($this->date_begin)) ? Yii::$app->formatter->asDate($this->date_begin, 'php:Y-m-d') : $this->date_begin;
        if ($this->date_begin != $this->date_end) {
            $date_end = (!empty($this->date_end)) ? Yii::$app->formatter->asDate($this->date_end, 'php:Y-m-d') : $this->date_end;
        } else {
            $date_end = NULL;
            $this->date_end = NULL;
        }
        $date_end_sale = (!empty($this->date_end_sale)) ? Yii::$app->formatter->asDate($this->date_end_sale, 'php:Y-m-d') : $this->date_end_sale;
        $query->FilterWhere(['=', 'tour.id', $this->id])
                ->andFilterWhere(['like', 'tour.title', $this->title])
                ->andFilterWhere(['like', 'country.name', $this->city_id])
                ->andFilterWhere(['like', 'hotel.name', $this->hotel_id])
                ->orFilterWhere(['like', 'category.name', $this->hotel_id])
                ->orFilterWhere(['like', 'city.name', $this->hotel_id])
                ->orFilterWhere(['like', 'type_food.name', $this->hotel_id])
                ->andFilterWhere(['like', 'tour.type_food.name', $this->type_food_id])
                ->andFilterWhere(['like', 'tour.date_departure', $date_departure])
                ->andFilterWhere(['like', 'tour.date_arrival', $date_arrival])
                ->andFilterWhere(['=', 'tour.length', $this->length])
                ->andFilterWhere(['like', 'dept_city.name', $this->dept_city_id])
                ->andFilterWhere(['like', 'transport.name', $this->type_transport_id])
                ->andFilterWhere(['like', 'operator.name', $this->operator_id])
                ->andFilterWhere(['=', 'tour.sale', $this->sale])
                ->andFilterWhere(['>=', 'tour.date_begin', $date_begin])
                ->andFilterWhere(['<=', 'tour.date_end', $date_end])
                ->andFilterWhere(['like', 'tour.date_end_sale', $date_end_sale])
                ->andFilterWhere(['like', 'tour.currency', $this->currency])
                ->andFilterWhere(['like', 'tour.old_price', $this->old_price])
                ->andFilterWhere(['like', 'tour.promo_price', $this->promo_price])
                ->andFilterWhere(['like', 'tour.price', $this->price])
                ->andFilterWhere(['=', 'tour.status', $this->status]);
        $temp = false;
        if ((int)$this->main == 99) {
            $query->andFilterWhere(['>', 'tour.main', 0]);
            $temp = true;
        }
        if ((int)$this->recommend == 99){
            $query->andFilterWhere(['>', 'tour.recommend', 0]);
            $temp = true;
        }
        if ((int)$this->hot == 99){
            $query->andFilterWhere(['>', 'tour.hot', 0]);
            $temp = true;
        }
        if (!$temp) {
            $query->andFilterWhere(['=', 'tour.main', $this->main])
                ->andFilterWhere(['=', 'tour.recommend', $this->recommend])
                ->andFilterWhere(['=', 'tour.hot', $this->hot]);
        }
        return $dataProvider;
    }

}
