<?php

namespace backend\modules\referenceBooks\models;

use backend\modules\user\entities\Passport;
use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class HotelReview extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName() {
        return 'hotel_review';
    }

    public function rules() {
        return [
            [['hotel_id', 'date', 'title', 'comment', 'vote', 'status'], 'required'],
            [['hotel_id', 'rid', 'vote','user_id'], 'number'],
            [['user', 'avatar', 'title'], 'string', 'length' => [0, 255]],
            [['status'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => false],
            [['status'],'safe']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['title','comment'];

        return $scenarios;
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hotel_id' => 'ID Отеля',
            'rid' => 'ID отзыва',
            'date' => 'Дата',
            'user' => 'Пользователь',
            'avatar' => 'Аватар',
            'title' => 'Название',
            'comment' => 'Комментарий',
            'vote' => 'Отзыв',
            'status' => 'Статус',
            'fullName' => 'Пользователь'
        ];
    }

    public function getHotel(): ActiveQuery
    {
        return $this->hasOne(Hotel::class, ['id' => 'hotel_id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPassport(): ActiveQuery
    {
        return $this->hasOne(Passport::class, ['id' => 'passport_id'])->via('author');
    }

}
