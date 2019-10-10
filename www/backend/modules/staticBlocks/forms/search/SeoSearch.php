<?php

namespace backend\modules\staticBlocks\forms\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\staticBlocks\entities\Block;

class SeoSearch extends Model
{
    public $id;
    public $title;
    public $description;
    public $status;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['title','description'], 'string'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Block::find()->where(['block' => 'seo']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        return $dataProvider;
    }
}