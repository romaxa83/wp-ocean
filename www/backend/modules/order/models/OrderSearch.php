<?php

namespace backend\modules\order\models;

use yii\data\ActiveDataProvider;
use backend\modules\order\models\Order;

class OrderSearch extends Order {

    public function rules() {
        return [
            [['id', 'hotel_id', 'offer', 'name', 'phone', 'email', 'status'], 'safe']
        ];
    }

    public function search($params, $page) {
        $query = Order::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
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

        $query->FilterWhere(['=', 'id', $this->id])
                ->andFilterWhere(['=', 'hotel_id', $this->hotel_id])
                ->andFilterWhere(['like', 'offer', $this->offer])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['=', 'status', $this->status]);
        return $dataProvider;
    }

}
