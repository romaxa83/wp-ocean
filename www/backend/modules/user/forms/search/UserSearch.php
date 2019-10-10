<?php

namespace backend\modules\user\forms\search;

use backend\modules\blog\entities\Category;
use common\models\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\modules\blog\entities\Post;

class UserSearch extends Model
{

    public $id;
    public $email;
    public $phone;
    public $created_at;
    public $first_name;
    public $last_name;
    public $role;

    public function rules(): array
    {
        return [
            [['id'],'integer'],
            [['first_name','last_name','role'],'string'],
            [['first_name','email','phone','created_at','role'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params,$page): ActiveDataProvider
    {
        $query = User::find()->where(['not',['user.id' => '1']]);

        $query->joinWith('passport');
        $query->joinWith('roleReletion');

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
                'email',
                'phone',
                'role',
                'created_at',
                'first_name' => [
                    'asc' => ['first_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC],
                ],
                'last_name' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
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
        $query
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'auth_assignment.item_name', $this->role])
            ->andFilterWhere(['like', 'user_passport.first_name', $this->first_name])
            ->andFilterWhere(['like', 'user_passport.last_name', $this->last_name]);
        $query->andFilterWhere(['>=', 'user.created_at', $this->created_at ? strtotime($this->created_at . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'user.created_at', $this->created_at ? strtotime($this->created_at . ' 23:59:59') : null]);

        return $dataProvider;
    }
}