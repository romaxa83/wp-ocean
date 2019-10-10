<?php

namespace backend\modules\faq\models;

use yii\data\ActiveDataProvider;

class FaqSearch extends Faq
{

    public function rules() {
        return [
            [['page_faq','page_vip','page_exo','page_hot','rate_faq','rate_vip','rate_exo','rate_hot','status'],'integer'],
            [['id', 'question', 'answer','category_id'], 'safe'],
        ];
    }

    public function exportFields()
    {
        return [
            'category_id' => function($model){
                $category = Category::find()->select('title')->where(['id' => $model->category_id])->one();
                return $category->title;
            },
        ];
    }

    public function search($params, $page)
    {
        $query = Faq::find();

        $query->joinWith(['category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => $page,
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->FilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['=', 'faq.id', $this->id])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'faq_category.name', $this->category_id])
            ->andFilterWhere(['=', 'faq.status', $this->status])
            ->andFilterWhere(['=', 'page_faq', $this->page_faq])
            ->andFilterWhere(['=', 'page_exo', $this->page_exo])
            ->andFilterWhere(['=', 'page_vip', $this->page_vip])
            ->andFilterWhere(['=', 'page_hot', $this->page_hot])
            ->andFilterWhere(['=', 'rate_faq', $this->rate_faq])
            ->andFilterWhere(['=', 'rate_exo', $this->rate_exo])
            ->andFilterWhere(['=', 'rate_vip', $this->rate_vip])
            ->andFilterWhere(['=', 'rate_hot', $this->rate_hot]);

        return $dataProvider;
    }

}
