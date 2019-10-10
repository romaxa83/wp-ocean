<?php

use yii\helpers\Json;

$children_info = 'Дети до 2-х лет - от рождения до 1,99 года, инфанты отдыхают бесплатно, оплачиваются только аэропортовый и топливный сборы и мед.страховка.';
$request = 'Оставить заявку - отправить запрос менеджеру для уточнения всех деталей  поездки, актуальной стоимости и последующего бронирования.';
?>
<div class="visible-1199">
    <div class="print-hidden">
        <div class="tour-right--footer flex-wrap">
            <div class="right-footer--item d-flex align-items-end">
                <div class="mr-3">
                    <?php if ($hotel['api']['descount_price'] == 0): ?>
                        <h2 class="descount-price font-size-18px">НЕТ ЦЕНЫ</h2>
                        <a href="" class="ways-read-more font-size-sm change-date-filter">измените дату</a>
                    <?php else : ?>
                        <h4 class="full-price mb-1 print-hidden"><?php //echo number_format($hotel['api']['price'], 2, '.', ' ') . ' ₴';           ?></h4>
                        <h2 class="descount-price print-hidden"><?php echo number_format($hotel['api']['descount_price'], 2, '.', ' ') . ' ₴'; ?></h2>
                        <div class="font-size-s small-text _mb print-hidden"><span>за весь тур</span></div>
                    <?php endif; ?>
                </div>
                <div class="prev-price-margin">
                    <h4 class="full-price mb-1">
                        <?php //echo number_format($hotel['api']['descount_price'], 2, '.', ' ') . ' ₴'; ?>
                    </h4>
                    <div class="d-flex align-items-center">
                        <span class="font-size-s small-text mr-1 print-hidden">дети до 2-х лет</span>
                        <span class="icon-unknown print-hidden" data-toggle="tooltip" data-html="true"
                              data-placement="bottom"
                              title="<small><?php echo $children_info; ?></small>">?</span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap print-hidden center-sm">
                <div class="right-footer--item mr-2 mb-2">
                    <?php if ($hotel['api']['price'] == 0): ?>
                        <a href="#" data-toggle="modal" data-target="#modal-order-tour" class="btn-regular btn-size-m button-isi">оставить заявку</a>
                    <?php else : ?>
                        <a href="#" data-toggle="modal" data-target="#modal-application-tour"
                           class="btn-regular btn-size-m button-isi" data-offer-id="<?php echo $hotel['api']['offer']; ?>" data-offer="<?php
                           echo htmlentities(Json::encode([
                                       'dateBegin' => $hotel['api']['date_begin'],
                                       'room' => $hotel['api']['room'],
                                       'insurance' => $hotel['api']['insurance'],
                                       'days' => $hotel['api']['length'],
                                       'food' => $hotel['api']['food'],
                                       'price' => $hotel['api']['price'],
                                       'offerId' => $hotel['api']['offer'],
                                       'hotelHid' => $hotel['hid'],
                                       'city' => $hotel['cites']['name'],
                                       'country' => $hotel['countries']['name'],
                                   ]), ENT_QUOTES, 'UTF-8');
                           ?>">оставить заявку</a>
                       <?php endif; ?>
                    <span
                        class="all-photo"
                        data-toggle="tooltip"
                        data-html="true"
                        data-placement="bottom"
                        title="<small><?php echo $request; ?></small>" >Что значит оставить заявку?</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tour-identification--list print-margin-b-28px">
    <div class="d-flex">
        <ul class="tour-list d-flex flex-wrap">
            <li class="tour-list--item before">
                <small>перелет</small>
                <?php echo 'Из ' . $hotel['api']['dept']; ?>
            </li>
            <li class="tour-list--item before">
                <small>дата вылета</small>
                <?php echo $hotel['api']['date_begin']; ?>
            </li>
            <li class="tour-list--item before">
                <small>ночей в туре</small>
                <?php echo $hotel['api']['length'] . ' ночей'; ?>
            </li>
            <li class="tour-list--item before">
                <small>питание</small>
                <?php echo $hotel['api']['food']; ?>
            </li>
            <li class="tour-list--item before">
                <small>проживание</small>
                <?php echo $hotel['api']['room'] ?>
            </li>
            <li class="tour-list--item before">
                <small>трансфер</small>
                А/п - отель - а/п
            </li>
            <li class="tour-list--item before">
                <small>туристы</small>
                <?php if ($hotel['api']['children'] > 0): ?>
                    <?php echo $hotel['api']['people'] . ' взр. + ' . $hotel['api']['children'] . ' реб'; ?>
                <?php else: ?>
                    <?php echo $hotel['api']['people'] . ' взр.'; ?>
                <?php endif; ?>
            </li>
            <li class="tour-list--item before">
                <small>страхование</small>
                <?php echo $hotel['api']['insurance']; ?>
            </li>
        </ul>
    </div>
    <?php if ($hotel['api']['descount_price'] == 0): ?>
        <span class="font-size-s small-text">К сожалению, на Ваши даты нет тура</span>
    <?php endif; ?>
</div>
<div class="tour-right--footer flex-wrap align-items-end hidden-1199">
    <div class="right-footer--item">
        <?php if ($hotel['api']['descount_price'] == 0): ?>
            <h2 class="descount-price font-size-18px">НЕТ ЦЕНЫ</h2>
            <a href="" class="ways-read-more font-size-sm change-date-filter">измените дату</a>
        <?php else : ?>
            <h4 class="full-price mb-1 print-hidden"><?php //echo number_format($hotel['api']['price'], 2, '.', ' ') . ' ₴';           ?></h4>
            <h2 class="descount-price print-hidden"><?php echo number_format($hotel['api']['descount_price'], 2, '.', ' ') . ' ₴'; ?></h2>
            <div class="font-size-s small-text _mb print-hidden"><span>за весь тур</span></div>
        <?php endif; ?>
        <div class="d-flex align-items-center">
            <script type="text/javascript">
                $('[data-toggle="tooltip"]').tooltip();
            </script>
            <span class="font-size-s small-text mr-1 print-hidden">дети до 2-х лет</span>
            <span class="icon-unknown print-hidden" data-toggle="tooltip" data-html="true"
                  data-placement="bottom"
                  title="<small><?php echo $children_info; ?></small>">?</span>
        </div>
    </div>
    <div class="right-footer--item print-hidden">
        <?php if ($hotel['api']['price'] == 0): ?>
            <a href="#" data-toggle="modal" data-target="#modal-order-tour" class="btn-regular btn-size-m button-isi">оставить заявку</a>
        <?php else : ?>
            <a href="#" data-toggle="modal" data-target="#modal-application-tour"
               class="btn-regular btn-size-m button-isi" data-offer-id="<?php echo $hotel['api']['offer']; ?>" data-offer="<?php
               echo htmlentities(Json::encode([
                           'dateBegin' => $hotel['api']['date_begin'],
                           'room' => $hotel['api']['room'],
                           'insurance' => $hotel['api']['insurance'],
                           'days' => $hotel['api']['length'],
                           'food' => $hotel['api']['food'],
                           'price' => $hotel['api']['price'],
                           'offerId' => $hotel['api']['offer'],
                           'hotelHid' => $hotel['hid'],
                           'city' => $hotel['cites']['name'],
                           'country' => $hotel['countries']['name'],
                       ]), ENT_QUOTES, 'UTF-8');
               ?>">оставить заявку</a>
           <?php endif; ?>
        <span class="all-photo"
              data-toggle="tooltip"
              data-html="true"
              data-placement="bottom"
              title="<small><?php echo $request; ?></small>">
            Что значит оставить заявку?
        </span>
    </div>
    <div class="right-footer--item">
        <!--
        <a href="#" class="btn-white btn-size-xs">
            <span class="font-size-lg">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"
                     xml:space="preserve">
                <path d="M470.4,82.1c-26.9-25.6-62.6-39.7-100.6-39.7c-38,0-73.7,14.1-100.6,39.7L256,94.7l-13.2-12.6
                      c-26.9-25.6-62.6-39.7-100.6-39.7c-38,0-73.7,14.1-100.6,39.7c-55.5,52.9-55.5,139,0,191.9l198.7,189.6c3.2,3.1,7.3,5,11.5,5.8
                      c1.4,0.3,2.8,0.4,4.3,0.4c5.6,0,11.3-2,15.5-6.1L470.4,274C525.9,221.1,525.9,135,470.4,82.1z"/>
                </svg>
            </span>
        </a>
        -->
    </div>
</div>
