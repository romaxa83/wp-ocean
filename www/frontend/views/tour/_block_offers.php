<?php

use backend\modules\blog\helpers\DateHelper;
use frontend\helpers\PriceHelper;
?>
<?php if (isset($hotel['api']['offers']) && count($hotel['api']['offers']) > 0): ?>
    <div class="tour-description--item hidden-991">
        <div class="description-column description-date">
            <span>Дата вылета</span>
        </div>
        <div class="description-column description-number">
            <span>Номер</span>
        </div>
        <div class="description-column description-days">
            <span>Длительность (ночей)</span>
        </div>
        <div class="description-column description-feeding">
            <span>Питание</span>
        </div>
        <div class="description-column description-price">
            <span>Стоимость</span>
        </div>
    </div>
    <?php $i = 0; ?>
    <?php foreach ($hotel['api']['offers'] as $k => $v): ?>
        <div class="tour-description--item white-bg <?php echo ($i >= 4) ? 'd-none' : FALSE; ?>">
            <div class="description-column description-date">
                <div class="visible-991 small-text">
                    <span>Дата вылета</span>
                </div>
                <span><?php echo Yii::$app->formatter->asDate($v['d'], 'php:d.m.Y'); ?></span>
            </div>
            <div class="description-column description-number">
                <div class="visible-991 small-text">
                    <span>Номер</span>
                </div>
                <span><?php echo $v['r']; ?></span>
            </div>
            <div class="description-column description-days">
                <div class="visible-991 small-text">
                    <span>Длительность (ночей)</span>
                </div>
                <span><?php echo $v['n']; ?></span>
            </div>
            <div class="description-column description-feeding">
                <div class="visible-991 small-text">
                    <span>Питание</span>
                </div>
                <span><?php echo $type_food[$v['f']]; ?></span>
            </div>
            <div class="description-column description-price">
                <div class="visible-991 small-text">
                    <span>Стоимость</span>
                </div>
                <div class="flex-inline flex-wrap">
                    <div class="font-size-md"><b><?php echo number_format($v['pl'], 2, '.', ' ') . ' ₴'; ?></b></div>
                    <!--                    <div>
                                            <span class="full-price"><?php //echo $v['pl'] . ' ₴'; ?></span>
                                        </div>-->
                </div>
            </div>
            <?php
            $data = [
                'dateBegin' => DateHelper::convertForPoint($v['d']),
                'room' => $v['r'],
                'insurance' => (array_search('insurance', $v['o']) !== FALSE) ? 'Да' : 'Нет',
                'days' => $v['n'],
                'food' => $type_food[$v['f']],
                'price' => PriceHelper::viewUahWithoutSymbol($v['pl']),
                'offerId' => $k,
                'hotelHid' => $hotel['hid'],
                'city' => $hotel['cites']['name'],
                'country' => $hotel['countries']['name'],
            ];
            $json = json_encode($data);
            ?>
            <div class="description-column description-action">
                <a href="#"
                   data-toggle="modal"
                   data-offer-id="<?php echo $k; ?>"
                   data-offer="<?php echo htmlentities($json, ENT_QUOTES, 'UTF-8'); ?>"
                   data-target="#modal-application-tour"
                   class="order-offer btn-white btn-size-m"
                   >оставить заявку</a>
            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>
    <?php if (count($hotel['api']['offers']) > 4): ?>
        <div class="more w-100">
            <button class="btn-regular btn-size-m button-isi btn-shadow ml-auto mr-auto more-tour">Показать ещё</button>
        </div>
    <?php endif; ?>
<?php else : ?>
    Нет данных
<?php endif; ?>
