<?php

namespace backend\modules\dispatch\helpers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\dispatch\entities\NewsLetter;

class Status
{
    public static function list()
    {
        return [
            NewsLetter::DRAFT => 'В ожидании',
            NewsLetter::START_SEND => 'Рассылка стартовала',
            NewsLetter::END_SEND => 'Рассылка завершена',
        ];
    }

    public static function label($status): string
    {
        switch ($status) {
            case 0:
                $class = 'label label-danger';
                break;
            case 1:
                $class = 'label label-info';
                break;
            case 2:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::list(), $status), [
            'class' => $class,
        ]);
    }

    public static function show($status)
    {
        return self::list()[$status];
    }
}