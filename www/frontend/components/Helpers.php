<?php


namespace frontend\components;


class Helpers
{
    public static function getPartsOfTitle($title)
    {
        $words = explode(' ', $title);
        $divided_title = array(
            'row_1' => $words[0],
            'row_2' => implode(' ', array_slice($words, 1))
        );

        return $divided_title;
    }
}