<?php

namespace backend\urls;

use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class AdminRule extends BaseObject implements UrlRuleInterface
{
    public function parseRequest($manager, $request)
    {
        if(preg_match('#^/admin/(.*)$#is',$request->getUrl()) || $request->getUrl() == '/admin'){

            if(\Yii::$app->user->isGuest){
                return [
                    'site/login',[]
                ];
            }
            return false;
        }

        if(preg_match('#^/admin(.*)$#is',$request->getUrl())){

            return [
                'site/front',[]
            ];
        }

        return false;
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }
}