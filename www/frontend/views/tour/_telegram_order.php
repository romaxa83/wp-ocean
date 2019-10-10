<?php

echo $subject . PHP_EOL .
 'Имя - ' . $data['name'] . PHP_EOL .
 'Номер - ' . $data['phone'] . PHP_EOL .
 'Email - ' . $data['email'] . PHP_EOL .
 'Комментарий - ' . $data['comment'] . PHP_EOL .
 'Информация о туре: ' . PHP_EOL .
 'Страна:' . $data['info']['country'] . PHP_EOL .
 'Город:' . $data['info']['city'] . PHP_EOL .
 'Отель:' . $data['info']['hotelName'] . PHP_EOL .
 'Стоимость: ' . $data['price'] . ' грн.' . PHP_EOL .
 'Колич-во чел: ' . $data['info']['people'] . PHP_EOL .
 'Ссылка на тур: ' . $link . PHP_EOL;
