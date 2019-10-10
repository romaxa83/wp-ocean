<?php

namespace backend\modules\blog\forms\search;

use backend\modules\blog\entities\HotelReview;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class HotelReviewSearch extends Model
{
    public $id;
    public $title;
    public $alias;
    public $status;
    public $hotel_id;
    public $created_at;

    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['title','alias','created_at','hotel_id'], 'safe'],
        ];
    }

//    public function exportFields()
//    {
//        return [
//            'category_id' => function($model){
//                $category = Category::find()->select('title')->where(['id' => $model->category_id])->one();
//                return $category->title;
//            },
//        ];
//    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params,$page): ActiveDataProvider
    {
        $query = HotelReview::find();

        $query->joinWith(['hotel']);

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
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['=', 'blog_hotel_review.id', $this->id]);
        $query->andFilterWhere(['like', 'hotel.name', $this->hotel_id]);

        $query
            ->andFilterWhere(['like', 'blog_hotel_review.title', $this->title])
            ->andFilterWhere(['like', 'blog_hotel_review.alias', $this->alias])
            ->andFilterWhere(['=', 'blog_hotel_review.status', $this->status]);

        $query->andFilterWhere(['>=', 'blog_hotel_review.created_at', $this->created_at ? strtotime($this->created_at . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'blog_hotel_review.created_at', $this->created_at ? strtotime($this->created_at . ' 23:59:59') : null]);

        return $dataProvider;
    }
}