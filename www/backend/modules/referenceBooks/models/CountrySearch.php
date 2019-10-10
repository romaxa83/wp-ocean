<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\Country;
use backend\models\Settings;

class CountrySearch extends Country {

    public function rules() {
        return [
            [['id', 'code', 'name', 'visa', 'status', 'sync'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = Country::find();
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

        $query->FilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['=', 'visa', $this->visa])
                ->andFilterWhere(['=', 'status', $this->status])
                ->andFilterWhere(['=', 'sync', $this->sync]);

        return $dataProvider;
    }

}
