<?php

namespace console\data;

class DataCounter
{
    public function countOne() : array
    {
        return [
            'alias' => 'counter_one',
            'title' => '21480',
            'description' => '<p>количество наших<br />клиентов</p>',
            'position' => 1
        ];
    }

    public function countTwo() : array
    {
        return [
            'alias' => 'counter_two',
            'title' => '501',
            'description' => '<p>туристов за границей сегодня</p>',
            'position' => 2
        ];
    }

    public function countThree() : array
    {
        return [
            'alias' => 'counter_three',
            'title' => '101',
            'description' => '<p>сегодня куплено<br />туров</p>',
            'position' => 3
        ];
    }

    public function countFour() : array
    {
        return [
            'alias' => 'counter_four',
            'title' => '201',
            'description' => '<p>сегодня забронировано туров</p>',
            'position' => 4
        ];
    }
}