<?php


namespace backend\modules\vacancyNotification\models;


use yii\data\ActiveDataProvider;

class VacancyNotificationSearch extends VacancyNotification
{
    public function rules() {
        return [
            [['id', 'name', 'phone', 'vacancy', 'cv_path', 'comment', 'status'], 'safe']
        ];
    }

    public function search($params, $page) {
        $query = VacancyNotification::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_ASC,
                    'created_at' => SORT_DESC
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
            ->andFilterWhere(['like', 'vacancy', $this->vacancy])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['=', 'status', $this->status]);
        return $dataProvider;
    }
}