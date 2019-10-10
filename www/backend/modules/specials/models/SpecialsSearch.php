<?php

namespace backend\modules\specials\models;

use yii\data\ActiveDataProvider;

class SpecialsSearch extends Special {

    public function rules() {
        return [
            [['id', 'name', 'status', 'from_datetime', 'to_datetime'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = Special::find();
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

        $query->FilterWhere(['=', 'id', $this->id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'from_datetime', $this->from_datetime])
            ->andFilterWhere(['like', 'to_datetime', $this->to_datetime])
            ->andFilterWhere(['=', 'status', $this->status]);

        return $dataProvider;
    }

}