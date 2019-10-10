<?php

namespace frontend\helpers;

class Dispatch
{
    public static function status($check)
    {
        $message_on = 'Вы подписаны на новости';
        $message_off = 'Вы были отключены от подписки на новости';
        return $check == 1 ? $message_on : $message_off;
    }
}