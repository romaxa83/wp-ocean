<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\TypeTour;

class TypeTourSearch extends TypeTour {

    public function rules() :array
    {
        return [
            [['id', 'code', 'name','status', 'sync'], 'safe'],
        ];
    }

    public function search($params, $page) {

        $query = TypeTour::find();

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

        $query->FilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'sync', $this->sync])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}