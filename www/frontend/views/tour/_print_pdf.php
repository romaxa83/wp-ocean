<?php

use yii\helpers\Url;
?>
<div class="hotel-name"><?php echo $hotel['name'] . ' ' . $hotel['category']['name']; ?></div></div>
<div>
    <div class="hotel-id"><?php echo 'id: ' . $hotel['id']; ?></div>
    <div class="hotel-country-city"><?php echo $hotel['countries']['name'] . ' / ' . $hotel['cites']['name']; ?></div>
</div>
<div class="mb-15">
    <div style="float: left;width: 190px;">
        <div class="full-price"><?php echo $hotel['full_price']; ?></div>
        <div class="descount-price"><?php echo $hotel['discount_price']; ?></div>
        <div class="hotel-all-tour">за весь тур</div>
        <div style="margin-top: 10px;font-size: 12px;width: 190px;">
            <div style="width: 85px; height: 50px; border: 1px solid #909090; border-radius: 4px; text-align: center; float: left;">
                <div style="color: #ff4800;font-size: 20px;font-weight: bold;"><?php echo (isset($hotel['review'][$hotel['id']]['avg'])) ? $hotel['review'][$hotel['id']]['avg'] : 0.0; ?></div>
                <div style="line-height: 1;">оценка</div>
            </div>
            <div style="width: 85px; height: 50px; border: 1px solid #909090; border-radius: 4px; text-align: center; float: right;">
                <div style="color: #ff4800;font-size: 20px;font-weight: bold;"><?php echo (isset($hotel['review'][$hotel['id']]['count'])) ? $hotel['review'][$hotel['id']]['count'] : 0; ?></div>
                <div style="line-height: 1;">отзывов</div>
            </div>
        </div>
    </div>
    <div style="float: right;width: 470px;padding-top:18px;">
        <?php if (count($hotel['info']) > 0): ?>
            <ul class="tour-list">
                <?php foreach ($hotel['info'] as $v): ?>
                    <li class="tour-list--item">
                        <span><small><?php echo $v['key']; ?></small><br><?php echo $v['value']; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php if (is_array($hotel['gallery']) && count($hotel['gallery']) > 3): ?>
    <div style="margin-top: 20px;">
        <div style="float: left;width:32.3%;height: 200px; background: url('<?php echo Url::to('admin/' . $hotel['gallery'][0]['url'], TRUE); ?>'); background-position: center center; background-repeat: no-repeat;"></div>
        <div style="float: left;width:32.3%;height: 200px;margin-right: 10px;margin-left: 10px; background: url('<?php echo Url::to('admin/' . $hotel['gallery'][1]['url'], TRUE); ?>'); background-position: center center; background-repeat: no-repeat;"></div>
        <div style="float: right;width:32.3%;height: 200px; background: url('<?php echo Url::to('admin/' . $hotel['gallery'][2]['url'], TRUE); ?>'); background-position: center center; background-repeat: no-repeat;"></div>
    </div>
<?php endif; ?>
<div style="margin-top: 20px;">
    <b>Описание:</b>
    <p><?php echo $hotel['address']['general_description']; ?></p>
</div>
<div>
    <?php if (count($hotel['about']) > 0): ?>
        <div class="title">Что входит в стоимость тура:</div>
        <ul class="tour-list" style="padding-left: 15px;padding-right: 15px;">
            <?php foreach ($hotel['about'] as $v): ?>
                <li class="tour-list--item" style="width: 29.7%;padding-left: 20px;">
                    <span><?php echo $v; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <p><?php echo $hotel['address']['food_description']; ?></p>
</div>
<div>
    <?php if (count($hotel['service']) > 0): ?>
        <div class="title">Самые популярные услуги:</div>
        <ul class="tour-list" style="padding-left: 15px;">
            <?php foreach ($hotel['service'] as $v): ?>
                <li class="tour-list--item" style="width: 29.7%;padding-left: 20px;">
                    <span><?php echo $v; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
