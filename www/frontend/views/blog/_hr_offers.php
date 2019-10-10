<?php
use backend\modules\blog\helpers\DateHelper;
use frontend\helpers\PriceHelper;
use yii\helpers\Url;

/** @var $hotel backend\modules\referenceBooks\models\Hotel*/
/** @var $tourOffers */
/** @var $typeFood */
/** @var $allRoom */
?>

<?php if($tourOffers):?>
    <div class="tour-description hotel-review-offers">
        <div class="tour-description--item hidden-991">
            <div class="description-column description-date">
                <span>Дата вылета</span>
            </div>
            <div class="description-column description-number"
                data-all-room="<?php echo htmlentities(json_encode($allRoom), ENT_QUOTES, 'UTF-8'); ?>">
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
        <?php $i = 0?>
        <?php foreach($tourOffers as $id => $offer):?>
            <div class="tour-description--item white-bg <?php echo ($i >= 4) ? 'd-none' : FALSE; ?>">
                <div class="description-column description-date">
                    <div class="visible-991 small-text"><span>Дата вылета</span></div>
                    <span><?= DateHelper::convertForOffers($offer['date'])?></span>
                </div>
                <div class="description-column description-number">
                    <div class="visible-991 small-text"><span>Номер</span></div>
                    <span><?= $offer['room']?></span>
                </div>
                <div class="description-column description-days">
                    <div class="visible-991 small-text"><span>Длительность (ночей)</span></div>
                    <span><?= $offer['days']?></span>
                </div>
                <div class="description-column description-feeding">
                    <div class="visible-991 small-text"><span>Питание</span></div>
                    <span><?= $typeFood[$offer['food']] ?></span>
                </div>
                <div class="description-column description-price">
                    <div class="visible-991 small-text"><span>Стоимость</span></div>
                    <div class="flex-inline flex-wrap">
                        <div class="font-size-md"><b><?= PriceHelper::viewUah($offer['price'])?></b></div>
                        <div>
<!--                            <span class="full-price">1 142 $</span>-->
                        </div>
                    </div>
                    <span class="d-none insurance"><?= $offer['insurance']?></span>
                </div>
                <?php $data = [
                        'dateBegin' => DateHelper::convertForPoint($offer['date']),
                        'room' => $offer['room'],
                        'insurance' => $offer['insurance'],
                        'days' => $offer['days'],
                        'food' => $typeFood[$offer['food']],
                        'price' => PriceHelper::viewUahWithoutSymbol($offer['price']),
                        'offerId' => $id,
                        'hotelHid' => $hotel->hid,
                        'city' => $hotel->cites->name,
                        'country' => $hotel->countries->name,
                ];$json = json_encode($data);?>
                <div class="description-column description-action">
                    <a href="#"
                       data-toggle="modal"
                       data-offer="<?php echo htmlentities($json, ENT_QUOTES, 'UTF-8'); ?>"
                       data-target="#modal-application-tour"
                       class="order-offer btn-white btn-size-m"
                    >оставить заявку</a>
                </div>
            </div>
            <?php $i++; ?>
        <?php endforeach;?>
        <?php if($tourOffers > 4):?>
            <div class="more w-100">
                <button class="btn-regular btn-size-m button-isi btn-shadow ml-auto mr-auto more-tour">больше туров</button>
            </div>
        <?php endif;?>
    </div>
<?php else:?>
    <p>Нет данных.</p>
<?php endif;?>

