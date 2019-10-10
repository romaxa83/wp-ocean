<?php

namespace frontend\widgets;

use backend\modules\blog\entities\HotelReview;
use common\models\User;
use DomainException;
use Yii;
use yii\base\Widget;

class ReviewWidget extends Widget
{
    public $user_id;
    public $hotel_review_id;

    public function run()
    {
        return $this->render('review-modal',[
            'user' => $this->getUser(),
            'hotel_id' => $this->getHotelId(),
            'hotel_review_id' => $this->hotel_review_id
        ]);
    }

    private function getUser()
    {
        if(!$user = User::find()->where(['id' => $this->user_id])->one()){
            throw new DomainException('Пользователь не найденю');
        }
        return $user;
    }
    private function getHotelId()
    {
        return HotelReview::find()->select('hotel_id')->where(['id' => $this->hotel_review_id])->one();
    }
}