<?php

use yii\helpers\Url;
use himiklab\yii2\recaptcha\ReCaptcha3;
use yii\helpers\Json;

$hs = Yii::$app->params['hotel_service'];
$this->title = (isset(Yii::$app->view->title) && !empty(Yii::$app->view->title)) ? Yii::$app->view->title : $hotel['name'];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
        </div>
    </div>
</div>
<!-- *** Section tour desc info *** -->
<section class="section section-review">
    <div class="container">
        <div class="row row-review">
            <div class="visible-1199">
                <div class="tour-name-top d-flex">
                    <div class="tour-name-wrapper d-flex flex-nowrap flex-lg-nowrap flex-xl-wrap">
                        <div class="d-flex flex-wrap">
                            <div class="hotel-name">
                                <h2 class="font-size-lg"><?php echo $hotel['name'] . ' ' . $hotel['category']['name']; ?></h2>
                            </div>
                            <div class="tour-identification-info d-flex flex-wrap">
                                <div class="tour-identification--item tour-identification--id font-size-s">
                                    <span>id: <?php echo $hotel['id']; ?></span>
                                </div>
                                <div class="tour-identification--item tour-identification--name font-size-s">
                                    <span><?php echo $hotel['countries']['name']; ?>
                                        / <?php echo $hotel['cites']['name']; ?></span>
                                </div>
                                <div class="print-hidden">
                                    <div class="tour-identification--item tour-identification--location font-size-s align-items-center d-none d-xl-flex">
                                        <span><i class="icon icon-map"></i></span>
                                        <span class="all-photo map-init" style="cursor: pointer;">на карте</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center justify-content-start justify-content-md-center tour-identification">
                        <div class="print-hidden">
                            <div class="d-flex align-items-center align-items-xl-end">
                                <div class="tour-identification--item tour-identification--location font-size-s align-items-center d-flex d-xl-none">
                                    <span><i class="icon icon-map"></i></span>
                                    <span class="all-photo map-init" style="cursor: pointer;">на карте</span>
                                </div>
                                <div class="preloader-block-review-info loader d-none"></div>
                                <div class="block-review-info"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $img = @getimagesize(Url::to('/admin/' . $hotel['gallery'][0]['url'], TRUE)); ?>
            <?php if ($img): ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-5 col-review--slider">
                    <div class="thumbnail-slider">
                        <div class="swiper-container gallery-top gallery-tour-top">
                            <?php if (!empty($special)) : ?>
                                <div class="gallery-top--sales">
                                    <div class="gallery-top--sales__icon">
                                        <object type="image/svg+xml" data="/img/pole.svg" width="90" height="25">
                                            <img src="/img/pole.svg" width="90" height="25" alt="image format png"/>
                                        </object>
                                        <span class="svg-article">АКЦИЯ</span>
                                    </div>
                                    <div class="gallery-top--sales__note">
                                        <p><?php echo $special; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="swiper-wrapper">
                                <?php foreach ($hotel['gallery'] as $k => $v): ?>
                                    <?php $info = @getimagesize(Url::to('/admin/' . $v['url'], TRUE)); ?>
                                    <div class="swiper-slide">
                                        <a href="<?php echo Url::to('/admin/' . $v['url'], TRUE); ?>"
                                           data-fancybox="gallery"
                                           data-caption="<?php echo $v['alt']; ?>"
                                           data-type="image"
                                           >
                                            <img
                                                src="<?php echo Url::to('/admin/' . $v['url'], TRUE); ?>"
                                                alt="<?php echo $v['alt']; ?>"
                                                data-size-x="<?php echo (isset($info[0])) ? $info[0] : ''; ?>"
                                                data-size-y="<?php echo (isset($info[0])) ? $info[1] : ''; ?>"
                                                >
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="card-header--common">
                                <div class="card--privileges">
                                    <?php if (isset($hotel['hotelService']) && count($hotel['hotelService']) > 0): ?>
                                        <div class="card--privileges ml-auto">
                                            <?php foreach ($hotel['hotelService'] as $k1 => $v1): ?>
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
                            <?php if (isset($hotel['discount']) && $hotel['discount'] != 0): ?>
                                <div class="snap snap-sale">
                                    <span><?php echo 'sale ' . $hotel['discount'] . ' %'; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper can-swipe">
                                <?php foreach ($hotel['gallery'] as $k => $v): ?>
                                    <div
                                        class="swiper-slide active"
                                        data-src="<?php echo Url::to('/admin/' . $v['url'], TRUE); ?>"
                                        data-index="<?php echo $k; ?>"
                                        data-alt="<?php echo $v['alt']; ?>">
                                        <img
                                            src="<?php echo Url::to('/admin/' . $v['url'], TRUE); ?>"
                                            alt="<?php echo $v['alt']; ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-5 pt-4 pb-4">
                    <img src="<?php echo Url::to('/admin/img/logo_no_photo.png', TRUE); ?>" alt="alt" class="img-not-found" />
                </div>
            <?php endif; ?>

            <div class="col-xs-12 col-sm-12 col-md-12 col-xl-7 col-review--desc">

                <div class="hidden-1199">
                    <div class="tour-name-top d-flex">
                        <div class="tour-name-wrapper d-flex flex-nowrap flex-lg-nowrap flex-xl-wrap">
                            <!--                        <div class="visible-1199 pl-0 pl-md-1">-->
                            <!--                            <a href="#" class="btn-white btn-size-xs">-->
                            <!--                                <span class="font-size-lg">-->
                            <!--                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"-->
                            <!--                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"-->
                            <!--                                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;"-->
                            <!--                                         xml:space="preserve">-->
                            <!--                                        <path d="M470.4,82.1c-26.9-25.6-62.6-39.7-100.6-39.7c-38,0-73.7,14.1-100.6,39.7L256,94.7l-13.2-12.6-->
                            <!--                                                                     c-26.9-25.6-62.6-39.7-100.6-39.7c-38,0-73.7,14.1-100.6,39.7c-55.5,52.9-55.5,139,0,191.9l198.7,189.6c3.2,3.1,7.3,5,11.5,5.8-->
                            <!--                                                                     c1.4,0.3,2.8,0.4,4.3,0.4c5.6,0,11.3-2,15.5-6.1L470.4,274C525.9,221.1,525.9,135,470.4,82.1z"/>-->
                            <!--                                    </svg>-->
                            <!--                                </span>-->
                            <!--                            </a>-->
                            <!--                        </div>-->
                            <div class="d-flex flex-wrap">
                                <div class="hotel-name">
                                    <div class="font-size-lg" style="font-weight: bold;"><?php echo $hotel['name'] . ' ' . $hotel['category']['name']; ?></div>
                                </div>
                                <div class="tour-identification-info d-flex flex-wrap">
                                    <div class="tour-identification--item tour-identification--id font-size-s">
                                        <span>id: <?php echo $hotel['id']; ?></span>
                                    </div>
                                    <div class="tour-identification--item tour-identification--name font-size-s">
                                        <span><?php echo $hotel['countries']['name']; ?>
                                            / <?php echo $hotel['cites']['name']; ?></span>
                                    </div>
                                    <div class="print-hidden">
                                        <div class="tour-identification--item tour-identification--location font-size-s align-items-center d-none d-xl-flex">
                                            <span><i class="icon icon-map"></i></span>
                                            <span class="all-photo map-init" style="cursor: pointer;">на карте</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-start justify-content-md-center tour-identification">
                            <div class="print-hidden">
                                <div class="d-flex align-items-center align-items-xl-end">
                                    <div class="tour-identification--item tour-identification--location font-size-s align-items-center d-flex d-xl-none">
                                        <span><i class="icon icon-map"></i></span>
                                        <span class="all-photo map-init" style="cursor: pointer;">на карте</span>
                                    </div>
                                    <div class="preloader-block-review-info loader d-none"></div>
                                    <div class="block-review-info"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tour-result-info" data-hotel="<?php echo $hotel['id']; ?>" data-hid="<?php echo $hotel['hid']; ?>" data-api="<?php
                echo htmlentities(Json::encode([
                            'deptCity' => (isset($get['deptCity'])) ? $get['deptCity'] : $data_api['deptCity'],
                            'to' => (isset($get['to'])) ? $get['to'] : 0,
                            'checkIn' => (isset($get['checkIn'])) ? $get['checkIn'] : $data_api['checkIn'],
                            'checkTo' => (isset($get['checkIn'])) ? $get['checkIn'] : $data_api['checkIn'],
                            'length' => (isset($get['length'])) ? $get['length'] : $data_api['length'],
                            'people' => (isset($get['people'])) ? $get['people'] : $data_api['people'],
                            'offerId' => (isset($get['offerId'])) ? $get['offerId'] : ''
                        ]), ENT_QUOTES, 'UTF-8');
                ?>" style="min-height: 204px;">
                    <div class="preloader-about-tour-full-price loader d-none" style="position: absolute;top: 50%;left: 50%;transform: translateX(-50%);"></div>
                </div>
                <div class="print-visible">
                    <div class="d-flex justify-content-start">
                        <?php foreach ($hotel['gallery'] as $k => $v): ?>
                            <?php if ($k <= 2): ?>
                                <div class="print-img--wrapper">
                                    <?php if (@getimagesize(Url::to('/admin/' . $v['url'], TRUE))) : ?>
                                        <img src="<?php echo Url::to('/admin/' . $v['url'], TRUE); ?>" alt="<?php echo $v['alt']; ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="tour-social-icons">
                    <ul class="social-icons--list">
                        <li><span class="social-item facebook-share" data-init="facebook"><img src="/img/icons/facebook-ico.png" alt="facebook"></span></li>
                        <li><span class="social-item telegram-share" data-init="telegram"><img src="/img/icons/telegram-ico.png" alt="telegram"></span></li>
                        <li><span class="social-item skype-share" data-init="skype"><img src="/img/icons/skype-ico.png" alt="skype"></span></li>
                        <li><span class="social-item viber-share" data-init="viber"><img src="/img/icons/viber-ico.png" alt="viber"></span></li>
                        <li>
                            <form id="print_form" method="POST" action="<?php echo URL::to('print', TRUE); ?>" target="_blank">
                                <input type="hidden" name="_csrf-frontend" value="<?php echo Yii::$app->request->getCsrfToken(); ?>">
                                <input type="hidden" name="info" readonly="readonly" />
                                <button type="submit" class="social-item print-me"/><img src="/img/icons/forma-ico.png" alt="forma" /></button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="tour-header font-size-sm">Описание:</h2>
                <div class="font-size-s truncate">
                    <p><?php echo $hotel['address']['general_description']; ?></p>
                </div>
                <?php if (isset($hotel['blogHotelReviews']['status']) && $hotel['blogHotelReviews']['status'] == 1): ?>
                    <a href="<?php echo Url::to('/blog/hotel/' . $hotel['alias'], TRUE); ?>" class="all-photo print-hidden">Больше информации об этом отеле в нашем блоге</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- *** Section tour info *** -->
<section class="section section-tour-info grey-bg print">
    <div class="container">
        <h2 class="tour-header _pb-24 font-size-lg">Что входит в стоимость тура:</h2>
        <div class="print-hidden">
            <div class="filter-buttons d-flex justify-content-start align-items-center">
                <button type="button" class="btn-filter active">О туре</button>
                <button type="button" class="btn-filter">Про отель</button>
                <button type="button" class="btn-filter tab-review-init">Отзывы</button>
                <button type="button" class="btn-filter tab-map-init">Карта</button>
            </div>
        </div>
        <div class="current-tour position-relative">
            <div class="current-tour--header d-flex flex-wrap">
                <div class="current-tour--side tour-left d-md-flex align-items-md-center">
                    <div>
                        <div class="d-flex align-items-baseline">
                            <h5 class="tour-hotel pr-2">
                                <?php echo $hotel['name'] . ' ' . $hotel['category']['name']; ?>
                            </h5>
                        </div>
                        <div class="tour-destination">
                            <span><?php echo $hotel['countries']['name']; ?> / <?php echo $hotel['cites']['name']; ?></span>
                        </div>
                    </div>
                    <div class="d-none">
                        <div class="reviews-rating is-total d-none">
                            <div class="d-flex align-items-center">
                                <div class="reviews-rating__total">0.0 из 0</div>
                                <div class="reviews-rating__pill-wrapper d-flex">
                                    <?php for ($i = 10; $i > 0; $i--): ?>
                                        <input id="star-10" type="radio" name="rating" value="<?php echo $i; ?>" disabled>
                                        <label for="<?php echo 'star-' . $i; ?>" class="mb-0">
                                            <i class="reviews-rating__pill" aria-hidden="true"></i>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                                <div class="reviews-rating__amount">0 отзывов</div>
                            </div>
<!--                        <div class="reviews-rating__position"><strong>№120</strong> из 150 отелей Алании</div>-->
                        </div>
                    </div>
                </div>
                <div class="current-tour--side tour-right pr-4 d-flex align-items-center">
                    <a href="https://www.turpravda.ua" target="_blank" rel="nofollow" class="tour-reviews-logo d-none mr-5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 401.65 66.83">
                        <defs>
                        <style>.cls-1{fill:#ff9700;}.cls-2{fill:#333;}</style>
                        </defs>
                        <g id="Layer_2" data-name="Layer 2">
                        <g id="Layer_1-2" data-name="Layer 1">
                        <polygon class="cls-1" points="13 57.92 13 10.92 0 10.92 0 0 39 0 39 10.92 26 10.92 26 57.92 13 57.92"/>
                        <polygon class="cls-1" points="43.38 0 43.38 36.25 69.83 36.25 69.83 47.58 43.38 47.58 43.38 58.58 82.83 58.58 82.83 0 69.83 0 69.83 25.42 55.88 25.42 55.88 0 43.38 0"/>
                        <path class="cls-1" d="M87.83,0V58.58h13.29V42.08h27V0ZM115.5,30.25H100.79V11.08H115.5Z"/>
                        <path class="cls-2" d="M178.92,0V58.58h13.29V42.08h27V0Zm27.67,30.25H191.88V11.08h14.71Z"/>
                        <polygon class="cls-2" points="133.5 58.58 133.5 0 173.5 0 173.5 58.58 160.5 58.58 160.5 11.08 146.63 11.08 146.63 58.58 133.5 58.58"/>
                        <path class="cls-2" d="M258.83,0h-30.5l-5.67,58.58H236l.83-13.83h13.5l.88,13.83h13.12Zm-21,33.42,1.33-22.5h8.33l1.5,22.5Z"/>
                        <path class="cls-2" d="M396.15,0h-30.5L360,58.58h13.33l.83-13.83h13.5l.88,13.83h13.13Zm-21,33.42,1.33-22.5h8.33l1.5,22.5Z"/>
                        <path class="cls-2" d="M308,22.17V0H268.5V58.58H308V36.42l-7.83-5.67V27.92ZM295,47.25H280.83V33.42h8.33L295,38.58Zm0-29.67-5.17,4.58h-9V10.92H295Z"/>
                        <path class="cls-2" d="M352.83,47.25V0h-31.5l-5.67,47.25H311.5V66.83h12.33V58.58H345v8.25h12.67V47.25Zm-10.83,0H326.67L332,10.92h10Z"/>
                        </g>
                        </g>
                        </svg>
                    </a>
                    <div class="preloader-about-tour-full-price loader d-none" style="margin-right: 70px;"></div>
                    <div class="about-tour-full-price d-none">
                        <h5 class="tour-price"></h5>
                        <div class="full-tour-price">
                            <span>Стоимость за весь тур</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="current-tour--body padding active print-d-block tour-tab-1">
                <div class="loader info d-none"></div>
                <div id="block_about_tour"></div>
            </div>
            <div class="current-tour--body padding tour-tab-2">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="font-size-s tour-desc"><?php echo $hotel['address']['location_description']; ?></p>
                    </div>
                </div>
                <?php if (isset($hotel['hotelAllService']) && count($hotel['hotelAllService']) > 0): ?>
                    <div class="row">
                        <?php
                        $limit = ceil(count($hotel['hotelAllService']) / 3);
                        $hotel_service = array_chunk($hotel['hotelAllService'], $limit);
                        ?>
                        <?php foreach ($hotel_service as $v): ?>
                            <div class="col-md-4">
                                <ul class="tour-list">
                                    <?php foreach ($v as $v1): ?>
                                        <li class="tour-list--item before"><?php echo $v1['name']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="current-tour--body padding pr-4">
                <div class="row row-tour-testimonials overflow-auto">
                    <div class="preloader-block-review loader d-none"></div>
                    <div class="col-md-12 block-review"></div>
                </div>
            </div>
            <div class="current-tour--body current-tour--body__map">
                <div id="map"></div>
                <div id="map-lat" class="d-none"><?php echo $hotel['address']['lat']; ?></div>
                <div id="map-lng" class="d-none"><?php echo $hotel['address']['lng']; ?></div>
                <div id="map-hotel-name" class="d-none"><?php echo $hotel['name']; ?></div>
                <div id="map-address" class="d-none"><?php echo $hotel['address']['address']; ?></div>
            </div>
        </div>
    </div>
    <div class="container get-block-offers print-hidden"
         data-id="<?php echo $hotel['id']; ?>"
         data-dept="<?php echo $data_api['deptCity']; ?>"
         data-to="<?php echo $hotel['hid']; ?>"
         data-people="<?php echo $data_api['people']; ?>">
        <h2 class="tour-header font-size-md"><?php echo 'Туры в отель ' . $hotel['name'] . ' ' . $hotel['category']['name']; ?></h2>
        <span class="hotelName d-none"><?php echo $hotel['name'] . ' ' . $hotel['category']['name']; ?></span>
        <div class="tour-desc d-flex justify-content-between flex-wrap">
            <p class="font-size-xs search-offer-info"></p>
            <div class="reset-filter">Изменить параметры поиска</div>
        </div>
        <div class="add-filter ">
            <div class="full-filter">
                <div class="filter-wrapper d-flex justify-content-start align-items-stretch">
                    <div class="filter-items d-flex justify-content-start align-items-stretch">
                        <div class="filter-items__item filter-items__item_date">
                            <div class="filter-items__header d-flex justify-content-between align-items-center">
                                <div class="date-inputs d-flex justify-content-center justify-content-lg-start align-items-center w-100">
                                    <div class="date-input-wrapper">
                                        <input type="text" name="filterDateStart" id="filterDateFrom" value="<?php echo Yii::$app->formatter->asDate($data_api['checkIn'], 'php:d.m.Y'); ?>" readonly data-value="<?php echo $data_api['checkIn']; ?>">
                                        <i class="icon icon-calendar"></i>
                                    </div>
                                    <span class="divider">-</span>
                                    <div class="date-input-wrapper">
                                        <input type="text" name="filterDateEnd" id="filterDateTo" value="<?php echo Yii::$app->formatter->asDate($data_api['checkTo'], 'php:d.m.Y'); ?>" readonly data-value="<?php echo $data_api['checkTo']; ?>">
                                        <i class="icon icon-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-dropdown-wrapper dropdown-menu non-event" id="filterDate"
                                 aria-labelledby="filterDateLink">
                            </div>
                        </div>
                        <div class="filter-items__item filter-items__item_country">
                            <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0" id="filterHotelRoomLink">
                                <select class="mobile-shadow-select d-md-none" name="filterHotelRoom"></select>
                                <select class="js-states form-control room-select search-select" name="filterHotelRoom" id="hotelRoom"></select>
                            </div>
                        </div>
                        <div class="filter-items__item filter-items__item_time">
                            <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0 length-range" id="filterDaysLink" data-range="<?php echo Yii::$app->params['filter_days_range']; ?>">
                                <?php
                                $limitDaysFrom = [1, 21];
                                $limitDaysTo = [1, 21];
                                ?>
                                <select class="mobile-shadow-select mobile-shadow-select--left d-md-none" name="shadowSelectDaysFrom" data-sourcename="filterDaysFrom">
                                    <?php for ($i = $limitDaysFrom[0]; $i <= $limitDaysFrom[1]; $i++): ?>
                                        <option <?php echo ($i == 6) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select class="mobile-shadow-select mobile-shadow-select--right d-md-none" name="shadowSelectDaysTo" data-sourcename="filterDaysTo">
                                    <?php for ($i = $limitDaysTo[0]; $i <= $limitDaysTo[1]; $i++): ?>
                                        <option <?php echo ($i == 7) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <div class="d-flex justify-content-center align-items-center w-100">
                                    <div class="d-flex align-items-center filter-items__header position-relative px-0">
                                        <div class="filter-items__item_time_divider">от</div>
                                        <select class="js-states form-control custom-select d-none js-filter-days-select" name="filterDaysFrom">
                                            <?php for ($i = $limitDaysFrom[0]; $i <= $limitDaysFrom[1]; $i++): ?>
                                                <option <?php echo ($i == 6) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="d-flex align-items-center filter-items__header position-relative px-0">
                                        <div class="filter-items__item_time_divider">до</div>
                                        <select class="js-states form-control custom-select d-none js-filter-days-select" name="filterDaysTo">
                                            <?php for ($i = $limitDaysTo[0]; $i <= $limitDaysTo[1]; $i++): ?>
                                                <option <?php echo ($i == 7) ? 'selected="selected"' : '' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="filter-items__item_time_divider">ночей</div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-items__item filter-items__item_country filter-checkboxes p-0">
                            <div class="filter-items__header d-flex justify-content-between align-items-center"
                                 id="filterNutritionLink"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                 data-drop-header="filterNutrition">
                                <span class="filter-items__title">Питание</span>
                                <i class="filter-caret "></i>
                            </div>
                            <div class="all-checkboxes filter-dropdown-wrapper dropdown-menu non-event"
                                 id="filterNutrition"
                                 aria-labelledby="filterNutritionLink">
                                <div class="main-checkbox">
                                    <input type="checkbox" name="all_nutrition" id="allNutrition"/>
                                    <label for="allNutrition">Все варианты</label>
                                </div>
                                <div class="checkboxes-wrapper">
                                    <div class="checkbox">
                                        <input type="checkbox" class="food-input" name="food[]" id="uai" value="uai"/>
                                        <label for="uai">UAI <span>ультра все включено</span></label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" class="food-input" name="food[]" id="ai" value="ai"/>
                                        <label for="ai">AI <span>все включено</span></label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" class="food-input" name="food[]" id="fb" value="fb"/>
                                        <label for="fb">FB <span>полный пансион</span></label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" class="food-input" name="food[]" id="hb" value="hb"/>
                                        <label for="hb">HB <span>завтрак и ужин</span></label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" class="food-input" name="food[]" id="bb" value="bb"/>
                                        <label for="bb">BB <span>завтрак</span></label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" class="food-input" name="food[]" id="ob" value="ob"/>
                                        <label for="ob">OB <span>без питания</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" data-url="/tour/search-offers" class="btn-find btn-regular btn-size-m button-isi" id="search-offers">
                        Найти
                    </button>
                </div>
            </div>
        </div>
        <div class="tour-description"></div>
        <div class="loader search-offers d-none"></div>
    </div>
</section>
<div id="block_promotional_tours" data-cid="<?php echo $hotel['country_id']; ?>" data-stars="<?php echo $hotel['category']['name']; ?>">
    <div class="loader promotional_tour d-none"></div>
</div>
<?php if (isset($seo) && !empty($seo)) : ?>
    <section class="section section-seo grey-bg">
        <div class="container invisible">
            <div class="seo-wrapper" id="collapseExample">
                <h1><?php echo $seo['h1']; ?></h1>
                <?php echo $seo['seo_text']; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- modal leave application for tour -->
<div class="modal-offer">
    <div class="modal fade" id="modal-application-tour" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="dialog">
            <div class="modal-content modal-action-notification">
                <form action="<?php echo Url::to('/tour/save-order', TRUE); ?>" method="post" id="form-save-order">
                    <div class="modal-header modal-header-center d-flex justify-content-center">
                        <h2 class="modal-title">оставить заявку на тур</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body--tour_info">
                            <div class="tour_info--component">
                                <div class="d-flex justify-content-sm-between mb-2">
                                    <h2 class="offerName font-size-18px font-weight-700"></h2>
                                    <div class="color-979797 hidden-sm">
                                        <span class="font-size-xs">За весь тур</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-sm-between">
                                    <h2 class="offerCountryCity font-size-s font-weight-400">></h2>
                                    <h4 class="offerPrice font-weight-800 font-size-md hidden-sm"></h4>
                                </div>
                            </div>

                            <div class="tour_info--component tour-list d-flex flex-wrap justify-content-between">
                                <div class="tour_info--component__item">
                                    <div class="tour-list--item before">
                                        <small>перелет</small>
                                        <div class="d-flex">
                                            Из&nbsp;<span class="offerDeptCity"></span>
                                        </div>
                                    </div>
                                    <div class="tour-list--item before">
                                        <small>дата вылета</small><span class="offerDateBegin"></span>
                                    </div>
                                </div>
                                <div class="tour_info--component__item">
                                    <div class="tour-list--item before">
                                        <small>проживание</small><span class="offerRoom"></span>
                                    </div>
                                    <div class="tour-list--item before">
                                        <small>питание</small><span class="offerFood"></span>
                                    </div>
                                </div>
                                <div class="tour_info--component__item">
                                    <div class="tour-list--item before">
                                        <small>ночей в туре</small>
                                        <div class="d-flex">
                                            <span class="offerDays"></span>
                                            <span>&#160;ночей</span>
                                        </div>
                                    </div>
                                    <div class="tour-list--item before">
                                        <small>туристы</small>
                                        <div class="d-flex">
                                            <span class="offerPeople"></span>
                                            <span>&#160;взр.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div class="tour_info--component visible-xs">-->
                            <!--                                <div class="d-flex justify-content-between flex-wrap align-items-center">-->
                            <!--                                    <span class="color-979797">За весь тур</span>-->
                            <!--                                    <h2 class="offerPrice font-size-lg font-weight-800"></h2>-->
                            <!--                                </div>-->
                        </div>
                    </div>
                    <div class="text-center mb-4 pt-4">
                        <span class="color-484848 font-weight-400 font-size-s">Остались вопросы? Позвоните нам!</span>
                        <h5 class="font-weight-700"><?php echo Yii::$app->view->params['phone']; ?></h5>
                    </div>
                    <div class="d-flex flex-wrap w-100">
                        <div class="modal-body--fields fields-left">
                            <input type="hidden" name="offer" readonly="readonly" value="">
                            <input type="hidden" name="hotel_id" readonly="readonly" value="">
                            <input type="hidden" name="price" readonly="readonly" value="">
                            <input type="hidden" name="info" readonly="readonly" value="">
                            <div class="form-group required-input">
                                <input type="text" name="name" placeholder="Ваше имя">
                            </div>
                            <div class="form-group required-input">
                                <input type="tel" name="phone" placeholder="Ваш телефон">
                            </div>
                            <div class="form-group required-input">
                                <input type="email" name="email" placeholder="Ваш e-mail">
                            </div>
                        </div>
                        <div class="modal-body--fields fields-right">
                            <div class="form-group">
                                <textarea name="comment" placeholder="Сообщение"></textarea>
                            </div>
                        </div>
                        <div class="recaptcha">
                            <?php
                            echo ReCaptcha3::widget([
                                'name' => 'reCaptcha',
                                'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                'action' => 'order'
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn-regular button-isi w-240px save-order" data-badge="inline">оставить заявку</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
