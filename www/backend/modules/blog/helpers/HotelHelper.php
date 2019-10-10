<?php

namespace backend\modules\blog\helpers;

class HotelHelper
{
    public $all_service = [
        'beachService' => 'Пляж',
        'childService' => 'Дети',
        'mainService' => 'Главное',
        'promoService' => 'Реклама',
        'recommendService' => 'Рекомендованные',
        'roomService' => 'Комната',
        'sportService' => 'Спорт',
    ];

    public function getPrettyServices($services)
    {
        $arr = [];

        foreach ($services as $service){
            if(array_key_exists($service->type,$this->all_service)){
                $arr[$this->all_service[$service->type]][] = $service->name;
            }
        }
        return $arr;
    }
}