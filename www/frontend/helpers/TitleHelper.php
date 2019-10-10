<?php

namespace frontend\helpers;

class TitleHelper
{

    public function getBlogTitle($alias,$name=null)
    {
        $title = '';
        switch ($alias) {
            case 'category' :
                $title = $name;
                break;
            case 'hotel':
                if($name){
                    $title = 'Обзор отеля ' . $name;
                }
                break;
            case 'country':
                if($name){
                    $title =  $name;
                }
                break;

            default:
                throw new \DomainException('Неверно передан алиас');
        }

        return $title;
    }
}