<?php

namespace backend\modules\user\forms\search;

use backend\modules\blog\entities\Category;
use backend\modules\user\entities\Reviews;
use common\models\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\modules\blog\entities\Post;

class ReviewsSearch extends Model
{

    public $id;
    public $rating;
    public $status;
    public $from_date;
    public $to_date;
    public $created_at;
    public $hotel;
    public $fullName;

    public function rules(): array
    {
        return [
            [['id','rating','status'],'integer'],
            [['hotel'],'string'],
            [['from_date','to_date','created_at','hotel','fullName'],'safe']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params,$page): ActiveDataProvider
    {
        $query = Reviews::find();

        $query->joinWith('hotel');
        $query->joinWith('passport');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => $page,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'text',
                'rating',
                'from_date',
                'to_date',
                'created_at',
                'status',
                'fullName' => [
                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ]
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

        $query->andFilterWhere(['=', 'user_reviews.rating', $this->rating]);

        $query->andFilterWhere(['like', 'hotel.name', $this->hotel]);

        if(strpos(trim($this->fullName),' ')){
            $name = explode(' ',$this->fullName);
            $query->andWhere('user_passport.first_name LIKE "%' . $name[0] . '%" ' .
            'OR user_passport.last_name LIKE "%' . $name[1] . '%"');
        } else {
            $query->orFilterWhere(['like', 'user_passport.first_name', $this->fullName]);
            $query->orFilterWhere(['like', 'user_passport.last_name', $this->fullName]);
        }

        $query->andFilterWhere(['=', 'user_reviews.status', $this->status]);

        $query->andFilterWhere(['>=', 'user_reviews.from_date', $this->from_date ? strtotime($this->from_date . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'user_reviews.from_date', $this->from_date ? strtotime($this->from_date . ' 23:59:59') : null]);

        $query->andFilterWhere(['>=', 'user_reviews.to_date', $this->to_date ? strtotime($this->to_date . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'user_reviews.to_date', $this->to_date ? strtotime($this->to_date . ' 23:59:59') : null]);

        $query->andFilterWhere(['>=', 'user_reviews.created_at', $this->created_at ? strtotime($this->created_at . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'user_reviews.created_at', $this->created_at ? strtotime($this->created_at . ' 23:59:59') : null]);

        return $dataProvider;
    }
}