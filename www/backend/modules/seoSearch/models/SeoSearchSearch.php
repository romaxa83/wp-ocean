<?php

namespace backend\modules\seoSearch\models;

use yii\data\ActiveDataProvider;
use backend\modules\seoSearch\models\SeoSearch;

class SeoSearchSearch extends SeoSearch {

    public function rules() {
        return [
            [['id', 'country_id', 'dept_city_id', 'city_id', 'status'], 'safe']
        ];
    }

    public function search($params, $page) {
        $query = SeoSearch::find()->joinWith('country')->joinWith('deptCity')->joinWith('city')->joinWith('seo');
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

        $query->FilterWhere(['=', 'seo_search.id', $this->id])
                ->andFilterWhere(['like', 'country.name', $this->country_id])
                ->andFilterWhere(['like', 'dept_city.name', $this->dept_city_id])
                ->andFilterWhere(['like', 'city.name', $this->city_id])
                ->andFilterWhere(['=', 'seo_search.status', $this->status]);
        return $dataProvider;
    }

}
