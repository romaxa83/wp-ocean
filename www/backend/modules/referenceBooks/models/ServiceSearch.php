<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\Service;

class ServiceSearch extends Service {

    public function rules() {
        return [
            [['id', 'code', 'name', 'include', 'price', 'status', 'sync'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = Service::find();
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

        $query->FilterWhere(['=', 'id', $this->id])
                ->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['=', 'include', $this->include])
                ->andFilterWhere(['=', 'price', $this->price])
                ->andFilterWhere(['=', 'status', $this->status])
                ->andFilterWhere(['=', 'sync', $this->sync]);

        return $dataProvider;
    }

}
