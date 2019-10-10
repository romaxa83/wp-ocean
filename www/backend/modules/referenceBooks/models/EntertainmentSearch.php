<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\Entertainment;

class EntertainmentSearch extends Entertainment {

    public function rules() {
        return [
            [['id', 'country_id', 'city_id', 'name', 'status'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = Entertainment::find()->joinWith('country')->joinWith('city')->joinWith('media');
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

        $query->FilterWhere(['like', 'country.name', $this->country_id])
                ->andFilterWhere(['like', 'city.name', $this->city_id])
                ->andFilterWhere(['like', 'entertainment.name', $this->name])
                ->andFilterWhere(['=', 'entertainment.status', $this->status]);

        return $dataProvider;
    }

}
