<?php

namespace backend\modules\request\helpers;

use backend\modules\request\models\Request;

class TypeHelper
{
    public static function getTypes() : array
    {
        return self::type();
    }

    public static function prettyType($type)
    {
        if(array_key_exists($type,self::type())){
            return self::type()[$type];
        }
    }

    private function type() : array
    {
        return [
            Request::TYPE_REQUEST => 'заявка',
            Request::TYPE_CONTACT => 'вопрос',
            Request::TYPE_DIRECTIONS => 'направления',
        ];
    }
}