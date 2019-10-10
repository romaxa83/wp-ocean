<?php

namespace backend\modules\referenceBooks\models;

use yii\data\ActiveDataProvider;
use backend\modules\referenceBooks\models\DeptCity;

class DeptCitySearch extends DeptCity {

    public function rules() {
        return [
            [['id', 'cid', 'name', 'status', 'sync'], 'safe'],
        ];
    }

    public function search($params, $page) {
        $query = DeptCity::find();
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
                ->andFilterWhere(['=', 'cid', $this->cid])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['=', 'status', $this->status])
                ->andFilterWhere(['=', 'sync', $this->sync]);

        return $dataProvider;
    }

}
