<?php

namespace backend\modules\dispatch\forms\search;

use backend\modules\dispatch\entities\NewsLetter;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\dispatch\entities\Notifications;

class NewsLetterSearch extends Model
{

    public $id;
    public $subject;
    public $body;
    public $send;
    public $status;

    public function rules(): array
    {
        return [
            [['id','status'], 'integer'],
            [['subject','body'], 'string'],
            [['send'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = NewsLetter::find();
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
            'subject' => $this->subject,
            'body' => $this->body,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['>=', 'send', $this->send ? strtotime($this->send . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'send', $this->send ? strtotime($this->send . ' 23:59:59') : null]);

        return $dataProvider;
    }
}