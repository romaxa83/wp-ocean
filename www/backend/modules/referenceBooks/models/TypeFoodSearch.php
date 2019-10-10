<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\TypeFood;

class TypeFoodSearch extends TypeFood {

    public function rules() {
        return [
            [['id', 'code', 'name', 'position', 'status', 'sync'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = TypeFood::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'position' => SORT_ASC,
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
                ->andFilterWhere(['=', 'status', $this->status])
                ->andFilterWhere(['=', 'sync', $this->sync]);

        return $dataProvider;
    }

}
