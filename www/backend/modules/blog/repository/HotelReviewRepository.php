<?php

namespace backend\modules\blog\repository;

use backend\modules\blog\entities\HotelReview;

class HotelReviewRepository
{

    public function get($id): HotelReview
    {
        if (!$hotelReview = HotelReview::findOne($id)) {
            throw new \DomainException('Hotel review is not found.');
        }
        return $hotelReview;
    }

    public function getWithSeo($id)
    {
        if (!$hotelReview = HotelReview::find()->where(['id' => $id])->with(['seo' => function($query){
            $query->andWhere(['alias' => 'review_hotel']);
        }])->one()) {
            throw new \DomainException('Hotel review is not found.');
        }

        return $hotelReview;
    }

    public function save(HotelReview $hotelReview): void
    {
        if (!$hotelReview->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(HotelReview $hotelReview): void
    {
        if (!$hotelReview->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function getIdBySlug($slug)
    {
        return (HotelReview::find()->select('id')->where(['alias' => $slug])->one())->id;
    }
}