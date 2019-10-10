<?php

namespace backend\modules\user\helpers;

use backend\modules\user\entities\SmartMailing;

class SmartMailingHelper
{
    public static function list() : array
    {
        return [
            SmartMailing::TYPE_NOTHING => 'не выбрано',
            SmartMailing::TYPE_EMAIL => 'email',
            SmartMailing::TYPE_TELEGRAM => 'telegram',
            SmartMailing::TYPE_VIBER => 'viber',
        ];
    }

    public static function getPrettyType($type)
    {
        if(!empty($type) && array_key_exists($type,self::list())){
            return self::list()[$type];
        }
    }

}