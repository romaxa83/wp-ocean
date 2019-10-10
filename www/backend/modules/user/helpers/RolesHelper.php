<?php

namespace backend\modules\user\helpers;

use yii\helpers\ArrayHelper;

class RolesHelper
{

    /**
     * принимает массив ролей (привязаных к пользователю)
     * возвращает массив конкретных данных (указаные в $nameData)
     * если указан флаг ,вернет строку
     * @param $data
     * @param $nameData
     * @param bool $flagStr
     * @return array|string
     */
    public static function getDataFromAuthManager($data, $nameData, $flagStr = false)
    {
        $arr = ArrayHelper::getColumn($data,$nameData);

        if($flagStr){
            return implode(',',$arr);
        }

        return $arr;
    }

    public static function getExistRoles($strRoles)
    {
        $roles = ['user','admin'];
        if(strpos($strRoles,',')){
            foreach (explode(',',$strRoles) as $role){
                $roles[] = $role;
            }
            return array_unique($roles);
        }

        $roles[] = $strRoles;

        return $roles;
    }

    public static function countRoles($strRoles)
    {
        if(empty($strRoles)){
            return 0;
        }
        if(strpos($strRoles,',')){
            return count(explode(',',$strRoles));
        }
        return 1;
    }

    public static function strFormatArray($str)
    {
        $roles = [];
        foreach (explode(',',$str) as $role){
            $roles[] = $role;
        }
        return $roles;
    }
}