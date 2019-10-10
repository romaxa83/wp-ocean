<?php

namespace backend\modules\blog\repository;

use backend\modules\referenceBooks\models\Country;
use yii\helpers\ArrayHelper;

class CountryReadRepository
{

    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllOnlyNameForAdmin()
    {
        $country = Country::find()->select(['id','name'])->where(['status' => 1])->asArray()->all();
        return ArrayHelper::map($country,'id','name');
    }

    /**
     * @return array|bool
     */
    public function getAllOnlyName()
    {
        if (!$categories = Country::find()->select(['id','name','alias'])->where(['status' => 1])->asArray()->all()) {
            return false;
        }

        return ArrayHelper::index($categories,'id');
    }

    /**
     * @return array|bool
     */
    public function getCountryAttachPosts()
    {
        if($attach_country = $this->postRepository->getPostsAttachCountry()){
            $country = $this->getAllOnlyName();
            if($country){
                $attach_country = ArrayHelper::map($attach_country,'country_id','country_id');

                return array_intersect_key($country,$attach_country);
            }
            return false;
        }
        return false;
    }

    public function getCountryName($country_id)
    {
        return (Country::find()->select('name')->where(['id' => $country_id])->one())->name;
    }

    public function getCountryIdByAlias($slug)
    {
        if($country = Country::find()->select(['id','name'])->where(['alias' => $slug])->one()){
            return $country;
        }

        return false;
    }
}