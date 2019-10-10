<?php

namespace backend\modules\dispatch\helpers;

class DateHelper
{
    private $timeZone = 'Europe/Kiev';

    private $format = 'd-m-Y H:i:s';

    /**
     * возвращает текущей время
     * @param string|bool $format
     * @return string
     */
    public function now($format = false)
    {
        return ($this->nowTime())->format($format ?: $this->format);
    }

    /**
     * возвращает текущее время формате unix-метки
     * @return int
     */
    public function nowTimestamp()
    {
        return ($this->nowTime())->getTimestamp();
    }

    /**
     * форматирует unix-метку в удобный формат времени
     * @param $timestamp
     * @param string|bool $format
     * @return string
     */
    public function formatTimestamp($timestamp, $format = false)
    {
        /** @var $date \DateTimeImmutable */
        $date = $this->timestamp($timestamp);
        return $date->format($format ?: $this->format);
    }

    /**
     * возвращаем разницу времени между двумя unix-метками (до часа)
     * @param $timestamp1
     * @param string|null $timestamp2
     * @return string
     */
    public function diffTimestamp($timestamp1, $timestamp2 = null)
    {
        /** @var $date1 \DateTimeImmutable */
        $date1 = $this->timestamp($timestamp1);
        /** @var $date2 \DateTimeImmutable */
        $date2 = $this->nowTimestamp();
        if($timestamp2){
            $date2 = $this->timestamp($timestamp2);
        }
        $interval = $date1->diff($date2);

        return $this->humanFormat($interval);
    }

    /**
     * возвращеат текущее время
     * @return \DateTimeImmutable
     */
    private function nowTime()
    {
        return new \DateTimeImmutable('now',new \DateTimeZone($this->timeZone));
    }

    /**
     * возвращает дату
     * @param $timestamp
     * @return bool|static
     */
    private function timestamp($timestamp)
    {
        return (new \DateTimeImmutable('',new \DateTimeZone($this->timeZone)))->setTimestamp($timestamp);
    }

    /**
     * из данных возвращаем удобный формат
     * @param \DateInterval $data
     * @return string
     */
    private function humanFormat(\DateInterval $data)
    {
        $hour = $data->h == 0 ? '00' : (strlen($data->h) == 1 ? '0'.$data->h:$data->h);
        $min = $data->i == 0 ? '00' : (strlen($data->i) == 1 ? '0'.$data->i:$data->i);
        $sec = $data->s == 0 ? '00' : (strlen($data->s) == 1 ? '0'.$data->s:$data->s);

        return $hour.':'.$min.':'.$sec;
    }
}