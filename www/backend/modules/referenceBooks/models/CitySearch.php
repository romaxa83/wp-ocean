<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\City;

class CitySearch extends City {

    public function rules() {
        return [
            [['id', 'code', 'name', 'capital', 'status', 'sync', 'country_id'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = City::find()->joinWith('country');
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

        $query->FilterWhere(['like', 'city.code', $this->code])
                ->andFilterWhere(['like', 'city.name', $this->name])
                ->andFilterWhere(['=', 'city.capital', $this->capital])
                ->andFilterWhere(['=', 'city.status', $this->status])
                ->andFilterWhere(['=', 'city.sync', $this->sync])
                ->andFilterWhere(['like', 'country.name', $this->country_id]);

        return $dataProvider;
    }

}
