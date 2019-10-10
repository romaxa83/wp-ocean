<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-list-2x">
        <ul class="tour-list">
            <li class="tour-list--item before"><?php echo 'Перелет из ' . $hotel['api']['dept']; ?></li>
            <li class="tour-list--item before"><?php echo 'Дата вылета ' . $hotel['api']['date_begin']; ?></li>
            <li class="tour-list--item before"><?php echo 'Кол-во ночей в туре: ' . $hotel['api']['length']; ?></li>
            <li class="tour-list--item before"><?php echo 'Кол-во человек в номере: ' . $hotel['api']['people']; ?></li>
        </ul>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-list-3x">
        <ul class="tour-list">
            <li class="tour-list--item before"><?php echo 'Проживание: ' . $hotel['api']['room']; ?></li>
            <li class="tour-list--item before"><?php echo 'Питание: ' . $hotel['api']['food']; ?></li>
            <li class="tour-list--item before">Трансфер эропорт - отель - аэропорт</li>
            <li class="tour-list--item before"><?php echo 'Страхование: ' . $hotel['api']['insurance']; ?></li>
        </ul>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-list-3x">
        <ul class="tour-list">
            <li class="tour-list--item before">Номер с видом на море без балкона</li>
            <li class="tour-list--item before">Региональный трансфер на территории Украины под запрос</li>
            <li class="tour-list--item before">Цена для детей до 2 лет уточняется отдельно у менеджера</li>
        </ul>
    </div>
</div>