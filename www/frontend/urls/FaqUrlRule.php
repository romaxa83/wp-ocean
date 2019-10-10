<?php

namespace frontend\urls;

use backend\modules\faq\repository\FaqCategoryRepository;
use yii\base\BaseObject;
use yii\helpers\Url;
use yii\web\UrlRuleInterface;

class FaqUrlRule extends BaseObject implements UrlRuleInterface
{
    public function parseRequest($manager, $request)
    {
        if(preg_match('#^faq/category/(.*)$#is',$request->pathInfo,$matches)){

//            dd($matches);
            $slug = explode('/',$matches[1]);

            return [
                'faq/category',
                [
                    'slug' => end($slug),
                ]
            ];
        }

        if(preg_match('#^faq/search(.*)$#is',$request->pathInfo,$matches)){

            $url = parse_url($request->url);
            parse_str($url['query'], $query);

            if(!isset($query['str'])){
                return false;
            }

            return [
                'faq/search',
                [
                    'params' => $query['str'],
                ]
            ];
        }

//        if(preg_match('#^faq/middleware$#is',$request->pathInfo,$matches)){
//die('1');
////            $url = parse_url($request->url);
////            parse_str($url['query'], $query);
////
////            if(!isset($query['str'])){
////                return false;
////            }
//
//            return [
//                'faq/middleware',
//            ];
//        }

        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        if($route == 'faq/category/slug'){
            if($this->getSlug()){
                return Url::toRoute(['/faq/category/'.$this->getSlug()]);
            }
            return false;
        }
        return false;
    }

    private function getSlug()
    {
        $faq = (new FaqCategoryRepository())->getFirstPositionCategory();

        if($faq){
            return $faq->alias;
        }

        return false;
    }
}