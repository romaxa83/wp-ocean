<?php

namespace backend\modules\referenceBooks\models;

use backend\modules\blog\helpers\DateHelper;
use backend\modules\referenceBooks\models\HotelReview;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class HotelReviewSearch extends Model
{
    public $id;
    public $title;
    public $vote;
    public $status;
    public $hotel_id;
    public $fullName;
    public $date;

    public function rules(): array
    {
        return [
            [['id', 'vote','status'], 'integer'],
            [['title','hotel_id','fullName','date'], 'safe'],
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
        $query->joinWith(['passport']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
//                'attributes' => ['id','title','hotel_id','fullName','date','vote','status'],
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

        $query->andFilterWhere(['=', 'hotel_review.id', $this->id]);

        if(strpos(trim($this->fullName),' ')){
            if(mb_strtolower(trim($this->fullName)) === 'не задано'){
                $query->orFilterWhere(['is', 'hotel_review.user_id', new \yii\db\Expression('null')]);
            } else {
                $name = explode(' ',$this->fullName);
                $query->andWhere('user_passport.first_name LIKE "%' . $name[0] . '%" ' .
                    'OR user_passport.last_name LIKE "%' . $name[1] . '%"');
            }
        } else {
            $query->orFilterWhere(['like', 'hotel_review.user', $this->fullName]);
            $query->orFilterWhere(['like', 'user_passport.first_name', $this->fullName]);
            $query->orFilterWhere(['like', 'user_passport.last_name', $this->fullName]);
        }

        $query->andFilterWhere(['like', 'hotel.name', $this->hotel_id]);

        $query
            ->andFilterWhere(['like', 'hotel_review.title',$this->title])
            ->andFilterWhere(['=', 'hotel_review.vote', $this->vote])
            ->andFilterWhere(['=', 'hotel_review.status', $this->status]);

        $query->andFilterWhere(['>=', 'hotel_review.date', $this->date ? DateHelper::convertForSearch($this->date) . ' 00:00:00' : null]);
        $query->andFilterWhere(['<=', 'hotel_review.date', $this->date ? DateHelper::convertForSearch($this->date) . ' 23:59:59' : null]);

        return $dataProvider;
    }
}