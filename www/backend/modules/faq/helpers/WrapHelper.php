<?php

namespace backend\modules\faq\helpers;

use yii\helpers\Html;

class WrapHelper
{
    public static function wrap($data) : string
    {
        return '<p class="text-center">'. $data .'</p>';
    }

    public static function input($data,$page,$id)
    {
        return Html::input('number','',$data,[
            'class' => 'form-control rate-faq',
            'data-page' => $page,
            'data-id' => $id
        ]);
    }
}