<?php

namespace backend\modules\dispatch\forms\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dispatch\entities\Notifications;

class NotificationsSearch extends Model
{

    public $id;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Notifications::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            //$query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        return $dataProvider;
    }
}