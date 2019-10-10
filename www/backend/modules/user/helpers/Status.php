<?php

namespace backend\modules\user\helpers;

use backend\modules\blog\entities\Post;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Status
{
    public static function list(): array
    {
        return [
            0 => 'Не верифицирован',
            1 => 'Верифицирован',
        ];
    }

    public static function verify($status): string
    {
        switch ($status) {
            case 0:
                $class = 'label label-danger';
                break;
            case 1:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::list(), $status), [
            'class' => $class,
        ]);
    }

    public static function getVerifyInfo($verify):string
    {
        if($verify == 0){
            return 'Паспорт верифицирован';
        }
        return 'Верификация паспорта отменена';
    }

    public static function getVerifyToggleInfo($verify):string
    {
        if($verify == 0){
            return 'Верифицирован отлючена';
        }
        return 'Верификация включена';
    }

    public static function getReviewsToggleInfo($status):string
    {
        if($status == 0){
            return 'Отзыв снят с публикации';
        }
        return 'Отзыв опубликован';
    }

}