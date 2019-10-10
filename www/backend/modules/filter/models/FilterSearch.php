<?php

namespace backend\modules\filter\models;

use yii\data\ActiveDataProvider;
use backend\modules\filter\models\Filter;

class FilterSearch extends Filter {

    public function rules() {
        return [
            [['id', 'alias', 'name', 'status'], 'safe']
        ];
    }

    public function search($params, $page) {
        $query = Filter::find()->orderBy(['date' => SORT_DESC]);
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
                ->andFilterWhere(['like', 'alias', $this->alias])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['=', 'status', $this->status]);
        return $dataProvider;
    }

}
