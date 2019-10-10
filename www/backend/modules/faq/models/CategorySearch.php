<?php

namespace backend\modules\faq\models;

use yii\data\ActiveDataProvider;

class CategorySearch extends Category
{
    public function rules()
    {
        return [
            [['name','alias','status'],'string'],
            [['position'],'integer']
        ];
    }

    public function search($params)
    {
        $query = Category::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['position' => SORT_ASC]
            ],
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->FilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['=', 'position', $this->position]);

        return $dataProvider;
    }

}
