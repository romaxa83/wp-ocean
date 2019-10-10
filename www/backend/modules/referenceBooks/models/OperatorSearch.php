<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\Operator;

class OperatorSearch extends Operator {

    public function rules() {
        return [
            [['id', 'oid', 'name', 'url', 'countries', 'currencies', 'status', 'sync'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = Operator::find();
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
                ->andFilterWhere(['=', 'oid', $this->oid])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'url', $this->url])
                ->andFilterWhere(['like', 'countries', $this->countries])
                ->andFilterWhere(['like', 'currencies', $this->currencies])
                ->andFilterWhere(['=', 'status', $this->status])
                ->andFilterWhere(['=', 'sync', $this->sync]);

        return $dataProvider;
    }

}
