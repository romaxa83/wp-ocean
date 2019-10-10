<?php

namespace backend\modules\request\models;

use yii\data\ActiveDataProvider;
use backend\modules\request\models\Request;

class RequestSearch extends Request {

    public function rules() {
        return [
            [['id', 'name', 'phone', 'email', 'status', 'type'], 'safe']
        ];
    }

    public function search($params, $page) {
        $query = Request::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
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
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['=', 'status', $this->status])
                ->andFilterWhere(['=', 'type', $this->type]);
        return $dataProvider;
    }

}
