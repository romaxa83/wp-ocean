<?php

namespace frontend\urls;

use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class BlogCategoryUrlRule extends BaseObject implements UrlRuleInterface
{
    public function parseRequest($manager, $request)
    {
        if(preg_match('#^blog/category/(.*)$#is',$request->pathInfo,$matches)){

            $slug = explode('/',$matches[1]);
            return [
                'blog/category',
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