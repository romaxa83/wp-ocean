<?php

namespace backend\modules\dispatch\forms\search;

use backend\modules\dispatch\entities\NewsLetter;
use backend\modules\dispatch\entities\Subscriber;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dispatch\entities\Notifications;

class SubscriberSearch extends Model
{
    public $email;
    public $status;

    public function rules(): array
    {
        return [
            [['status'], 'integer'],
            [['email'], 'string'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Subscriber::find();
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
            'email' => $this->email,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}