<?php

use yii\helpers\Url;

$hs = Yii::$app->params['hotel_service'];
?>
<?php foreach ($hotel_list as $v): ?>
    <?php $img = @getimagesize(Url::to('/admin/' . $v['media']['url'], TRUE)); ?>
    <div class="result-card col-xs-12 col-md-6 col-xl-4">
        <div class="card card-size-s ">
            <div class="card-header">
                <a href="<?php echo $v['link']; ?>" target="_blank">
                    <div class="card-header--image preloader-inner">
                        <?php if ($img): ?>
                            <img src="<?php echo Url::to('/admin/' . $v['media']['url'], TRUE); ?>" alt="<?php echo $v['media']['alt']; ?>" />
                        <?php else : ?>
                            <img src="<?php echo Url::to('/admin/img/logo_no_photo.png', TRUE); ?>" alt="" class="img-not-found" />
                        <?php endif; ?>
                        <div class="card-header--common">
                            <div class="card--rating text-white font-montserrat font-size-s">
                                <span><strong><?php echo (isset($hotel_review[$v['id']]['avg'])) ? $hotel_review[$v['id']]['avg'] : 0.0; ?></strong> оценка</span>
                            </div>
                            <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                <span><strong><?php echo (isset($hotel_review[$v['id']]['count'])) ? $hotel_review[$v['id']]['count'] : 0; ?></strong> </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="card-body">
                <div class="card-body-wrapper">
                    <div class="card-body--title d-flex justify-content-between">
                        <a href="<?php echo $v['link']; ?>" class="card-body--title__link" target="_blank"><?php echo $v['name'] . ' ' . $v['category']['name']; ?></a>
                        <!--<i class="icon icon-map list-hidden"></i>-->
                    </div>
                    <div class="card-body--region d-flex align-items-center justify-content-start">
                        <p>
                            <span class="text-uppercase"><?php echo $v['countries']['name']; ?></span> <?php echo $v['cites']['name']; ?>
                        </p>
                        <!--<i class="icon icon-map cube-hidden"></i>-->
                    </div>
                    <div class="tour-identification--list cube-hidden">
                        <ul class="tour-list d-flex flex-wrap">
                            <li class="tour-list--item before">
                                <small>перелет</small><?php echo 'Из ' . $hotels_info[$v['hid']]['dept'] ?>
                            </li>
                            <li class="tour-list--item before">
                                <small>дата вылета</small><?php echo $hotels_info[$v['hid']]['date_begin'] ?>
                            </li>
                            <li class="tour-list--item before">
                                <small>ночей в туре</small><?php echo $hotels_info[$v['hid']]['length'] . ' ночей'; ?>
                            </li>
                            <li class="tour-list--item before">
                                <small>проживание</small><?php echo $hotels_info[$v['hid']]['room']; ?>
                            </li>
                            <li class="tour-list--item before">
                                <small>трансфер</small>А/п - отель - а/п
                            </li>
                            <li class="tour-list--item before">
                                <small>туристы</small><?php echo $hotels_info[$v['hid']]['people'] . ' взр.' . ((isset($hotels_info[$v['hid']]['child']) && !empty($hotels_info[$v['hid']]['child'])) ? ' + ' . $hotels_info[$v['hid']]['child'] . ' реб.' : ''); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body--desc list-hidden">
                        <?php echo 'Из ' . $hotels_info[$v['hid']]['dept'] . ' ' . $hotels_info[$v['hid']]['date_begin'] . ', ' . $hotels_info[$v['hid']]['length'] . ' ночей, питание ' . $hotels_info[$hotels[$v['hid']]]['food'] . ', цена за ' . $hotels_info[$hotels[$v['hid']]]['people'] . ' чел.' ?>
                    </div>
                </div>
                <div class="cube-hidden card--privileges ">
                    <?php if (isset($v['hotelService']) && count($v['hotelService']) > 0): ?>
                        <div class="card--privileges ml-auto">
                            <?php foreach ($v['hotelService'] as $k1 => $v1): ?>
                                <?php if (isset($hs[$v1['code']])): ?>
                                    <button class="snap snap-size-xs" data-toggle="tooltip" data-html="true" title="<?php echo $v1['name'] ?>">
                                        <object type="image/svg+xml" data="<?php echo Url::to('img/service_icon/' . $hs[$v1['code']], TRUE); ?>" width="20" height="20">
                                            <img src="<?php echo Url::to('img/service_icon/' . $hs[$v1['code']], TRUE); ?>" width="20" height="20" alt="image format png" />
                                        </object>
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo $v['link']; ?>" class="btn-regular btn-size-m button-isi" target="_blank">Подробнее</a>
                <div class="card-footer--prices">
                    <!-- <h6 class="full-price"><?php //echo number_format($hotels_info[$v['hid']]['price'], 2, '.', ' ') . ' ₴'; ?></h6> -->
                    <div class="descount-price"><small>от</small> <?php echo number_format($hotels_info[$v['hid']]['price'], 2, '.', ' ') . ' ₴'; ?></div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
