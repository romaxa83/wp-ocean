<?php

namespace console\data;

class DataSmart
{
    public function stepOne() : array
    {
        return [
            'alias' => 'step_one',
            'title' => '15, 100',
            'description' => '<p>Выберите направление</p>',
            'position' => 1
        ];
    }

    public function stepTwo() : array
    {
        return [
            'alias' => 'step_two',
            'title' => '30, 100',
            'description' => '<p>Задайте временной промежуток поездки</p>',
            'position' => 2
        ];
    }

    public function stepThree() : array
    {
        return [
            'alias' => 'step_three',
            'title' => '50, 100',
            'description' => '<p>Укажите количество человек</p>',
            'position' => 3
        ];
    }

    public function stepFour() : array
    {
        return [
            'alias' => 'step_four',
            'title' => '65, 100',
            'description' => '<p>Выберите способ получения предложений: -mail, telegram,viber</p>',
            'position' => 4
        ];
    }

    public function stepFive() : array
    {
        return [
            'alias' => 'step_five',
            'title' => '80, 100',
            'description' => '<p>Подключите рассылку</p>',
            'position' => 5
        ];
    }

    public function stepSix() : array
    {
        return [
            'alias' => 'step_six',
            'title' => '100, 100',
            'description' => '<p>Получите лучшее предложение</p>',
            'position' => 6
        ];
    }
}