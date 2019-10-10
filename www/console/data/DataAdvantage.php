<?php

namespace console\data;

class DataAdvantage
{
    public function service() : array
    {
        return [
            'alias' => 'service',
            'title' => '<i class="icon icon-repairing"></i>',
            'description' => '<p>Европейские стандарты сервиса</p>',
            'position' => 1
        ];
    }

    public function exclusive() : array
    {
        return [
            'alias' => 'exclusive',
            'title' => '<i class="icon icon-diamond"></i>',
            'description' => '<p>Эксклюзивные продукты</p>',
            'position' => 2
        ];
    }

    public function true() : array
    {
        return [
            'alias' => 'exclusive',
            'title' => '<i class="icon icon-key"></i>',
            'description' => '<p>Мы всегда говорим правду об отелях своим клиентам</p>',
            'position' => 3
        ];
    }

    public function quality() : array
    {
        return [
            'alias' => 'quality',
            'title' => '<i class="icon icon-sale"></i>',
            'description' => '<p>Лучшее соотношение <br />цена / качество</p>',
            'position' => 4
        ];
    }
}