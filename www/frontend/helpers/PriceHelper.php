<?php

namespace frontend\helpers;

class PriceHelper
{
    public static function viewUah($price)
    {
        return number_format($price, 2, '.', ' ') . ' ₴';
    }

    public static function viewUahWithoutSymbol($price)
    {
        return number_format($price, 2, '.','');
    }

    public static function viewUahWithDiscount($price,$discount)
    {
        return number_format((round(($price - ($price / 100) * $discount), 2)), 2, '.', ' ') . ' ₴';
    }
}