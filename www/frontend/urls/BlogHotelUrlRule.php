<?php

namespace frontend\urls;

use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class BlogHotelUrlRule extends BaseObject implements UrlRuleInterface
{

    public function parseRequest($manager, $request)
    {
        if(preg_match('#^blog/hotel/(.*)$#is',$request->pathInfo,$matches)){

            $slug = explode('/',$matches[1]);

            return [
                'blog/hotel',
                [
                    'slug' => end($slug),
                    'params' => isset($matches[2])?$matches[2]:'',
                ]
            ];
        }

        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }
}