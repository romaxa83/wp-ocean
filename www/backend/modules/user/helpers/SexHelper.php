<?php

namespace backend\modules\user\helpers;

use backend\modules\user\entities\IntPassport;

class SexHelper
{
    public static function list($type=null)
    {
        $list = [
            IntPassport::MAN => 'Мужчина',
            IntPassport::WOMAN => 'Женщина',
            IntPassport::CHILD => 'Ребенок',
            IntPassport::BABY => 'Младенец'
        ];
        if($type){
            return $list[$type];
        }
        return $list;
    }

}