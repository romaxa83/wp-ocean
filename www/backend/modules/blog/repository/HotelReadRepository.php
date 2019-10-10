<?php

namespace backend\modules\blog\repository;

use backend\modules\blog\entities\HotelReview;
use backend\modules\referenceBooks\models\Hotel;
use backend\modules\referenceBooks\models\TypeFood;
use yii\helpers\ArrayHelper;

class HotelReadRepository
{
    /**
     * @return array|bool
     */
    public function getAllOnlyName()
    {
        if (!$hotels = Hotel::find()->select(['id','name'])->where(['status' => 1])->asArray()->all()) {
            return false;
        }
        return ArrayHelper::map($hotels,'id','name');
    }

    /**
     * @return array|bool
     */
    public function getExistsReview()
    {
        if ($hotels_id = HotelReview::find()->select('hotel_id')->where(['status' => HotelReview::ACTIVE])->asArray()->all()) {

            $hotel = Hotel::find()->select(['id','name','alias'])
                ->where(['in','id',ArrayHelper::map($hotels_id,'hotel_id','hotel_id')])->asArray()->all();

            return ArrayHelper::index($hotel,'id');
        }
        return false;
    }

    public function getAllByHotel($id,$limit = null)
    {
        if($hotelReview = HotelReview::find()->where(['hotel_id' => $id])->andWhere(['status' => HotelReview::ACTIVE])->orderBy(['published_at' => SORT_DESC])->limit($limit)->all()){
            return $hotelReview;
        }
        return false;
    }

    public function getAllByHotelCount($id)
    {
        if($hotelReview = HotelReview::find()->where(['hotel_id' => $id])->andWhere(['status' => HotelReview::ACTIVE])->count()){
            return $hotelReview;
        }
        return false;
    }

    public function getHotelReviewForFrontend($id)
    {
        return HotelReview::find()->where(['id' => $id])->andWhere(['status' => HotelReview::ACTIVE])
            ->with(['seo' => function($query){
                $query->andWhere(['alias' => 'review_hotel']);
             }])
            ->with('hotel')
            ->with('hotel.category')
            ->with('hotel.countries')
            ->with('hotel.cites')
            ->one();
    }

    public function getHotelByHid($hid)
    {
        if($hotelReview = Hotel::find()
            ->where(['hid' => $hid])
            ->with('countries')
            ->with('cites')
            ->one()){
            return $hotelReview;
        }
        return false;
    }

    public function getTypeFood()
    {
        $type = TypeFood::find()->select(['code','name'])->asArray()->all();
        $arr =[];
        foreach ($type as $item){
            $arr[$item['code']] = $item['name'];
        }

        return $arr;
    }

    public function getHotelIdByAlias($slug)
    {
        if($hotel = Hotel::find()->select(['id','name'])->where(['alias' => $slug])->one()){
            return $hotel;
        }

        return false;
    }
}