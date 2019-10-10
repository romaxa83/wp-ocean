<?php

namespace backend\modules\staticBlocks\helpers;

class InfoFlash
{
    const BLOCKS_NAME = [
        'advantage' => 'Наши преимущества',
        'smart' => 'Smart рассылка',
        'counter' => 'Счетчик',
        'seo' => 'SEO',
        'company' => 'О компании'
    ];

    public static function block($status,$nameBlock)
    {
        if($status == 'true'){
            return 'Блок " ' . self::BLOCKS_NAME[$nameBlock] . ' " опубликован';
        }
        return 'Блок " ' . self::BLOCKS_NAME[$nameBlock] . ' " снят с публикации';
    }

    public static function sectionBlock($status,$nameBlock)
    {
        if($status == '1'){
            return 'Данная секция,блока " ' . self::BLOCKS_NAME[$nameBlock] . ' " опубликован';
        }
        return 'Данная секция,блока " ' . self::BLOCKS_NAME[$nameBlock] . ' " снят с публикации';
    }
}