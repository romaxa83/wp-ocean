<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\Hotel;

class HotelSearch extends Hotel {

    public function rules() {
        return [
            [['id', 'hid', 'country_id', 'city_id', 'category_id', 'name', 'status', 'sync'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = Hotel::find()->joinWith('countries')->joinWith('cites')->joinWith('media')->distinct();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $page,
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->FilterWhere(['=', 'hotel.id', $this->id])
                ->andFilterWhere(['=', 'hotel.hid', $this->hid])
                ->andFilterWhere(['like', 'country.name', $this->country_id])
                ->andFilterWhere(['like', 'city.name', $this->city_id])
                ->andFilterWhere(['=', 'category_id', $this->category_id])
                ->andFilterWhere(['like', 'hotel.name', $this->name])
                ->andFilterWhere(['=', 'hotel.status', $this->status])
                ->andFilterWhere(['=', 'hotel.sync', $this->sync]);

        return $dataProvider;
    }

}
