<?php
;
use frontend\helpers\PriceHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/** @var $reviewHelper backend\modules\blog\helpers\ReviewsHelper*/
/** @var $tourHotel */
?>
<section class="section tour-in-review section-sales grey-bg">
    <div class="container">
        <h2 class="tour-header font-size-md text-uppercase mb-4">
            Вас также может заинтересовать:
        </h2>
    </div>
    <div class="container container-md-mw">
        <div class="row">
            <div class="swiper-container swiper-blog-container2">
                <div class="swiper-wrapper flex-xl-wrap">
                    <?php foreach ($tourHotel as $tour):?>
                        <div class="swiper-slide swiper-slide-interested">
                            <div class="card card-size-s">
                                <div class="card-header">
                                    <a href="<?= Url::toRoute([
                                        '/tour/'.$tour['hotel']['countries']['alias'].'/'.$tour['hotel']['cites']['alias'].'/'.$tour['hotel']['alias'],
                                        'id' => $tour['id'],
                                        'checkIn' => (DateTime::createFromFormat('Y-m-d H:i:s',$tour['date_begin']))->format('Y-m-d'),
                                        'checkTo' => (DateTime::createFromFormat('Y-m-d H:i:s',$tour['date_end']))->format('Y-m-d')
                                    ])?>">
                                        <div class="card-header--image">
                                            <img
                                                    src="<?= '/admin/'.$tour['hotel']['media']['url']?>"
                                                    alt="<?= \backend\modules\blog\helpers\ImageHelper::getAltForArray($tour['hotel']['media'])?>"
                                            >
                                            <div class="card-header--common">
                                                <?php if ($reviewHelper->getReviewsRating($tour['hotel']['reviews']) != '0.0'): ?>
                                                    <div class="card--rating text-white font-montserrat font-size-s">
                                                        <span><strong><?= $reviewHelper->getReviewsRating($tour['hotel']['reviews'])?></strong> оценка</span>
                                                    </div>
                                                <?php endif;?>
                                                <?php if ($reviewHelper->getCountReview($tour['hotel']['reviews']) != '0'):?>
                                                    <div class="card--rating text-white font-montserrat font-size-s">
                                                        <span><strong><?= $reviewHelper->getCountReview($tour['hotel']['reviews'])?></strong> отзывов</span>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="card-body--region d-flex">
                                        <a href="<?= Url::toRoute([
                                            '/tour/'.$tour['hotel']['countries']['alias'].'/'.$tour['hotel']['cites']['alias'].'/'.$tour['hotel']['alias'],
                                            'id' => $tour['id'],
                                            'checkIn' => (DateTime::createFromFormat('Y-m-d H:i:s',$tour['date_begin']))->format('Y-m-d'),
                                            'checkTo' => (DateTime::createFromFormat('Y-m-d H:i:s',$tour['date_end']))->format('Y-m-d')
                                        ])?>"><?=$tour['hotel']['name'] . ' ' . $tour['hotel']['category']['name']?></a>
                                        <i class="icon icon-map"></i>
                                    </div>
                                    <div class="card-body--hotel d-flex align-items-center">
                                        <div><span class="text-uppercase"><?=$tour['hotel']['countries']['name']?></span>
                                            <?=$tour['hotel']['cites']['name']?></div>
                                    </div>
                                    <div class="card-body--desc">
                                        <?=StringHelper::truncateWords($tour['hotel']['address']['general_description'],10)?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?= Url::toRoute([
                                        '/tour/'.$tour['hotel']['countries']['alias'].'/'.$tour['hotel']['cites']['alias'].'/'.$tour['hotel']['alias'],
                                        'id' => $tour['id'],
                                        'checkIn' => (DateTime::createFromFormat('Y-m-d H:i:s',$tour['date_begin']))->format('Y-m-d'),
                                        'checkTo' => (DateTime::createFromFormat('Y-m-d H:i:s',$tour['date_end']))->format('Y-m-d')
                                    ])?>" class="btn-regular btn-size-m button-isi">Подробнее</a>
                                    <div class="card-footer--prices">
                                        <!-- <h6 class="full-price"><?php //echo PriceHelper::viewUah($tour['price'])?></!-->
                                        <div class="descount-price"><small>от</small>
                                            <?= PriceHelper::viewUahWithDiscount($tour['price'],5)?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
                <div class="visible-1199">
                    <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
                </div>
            </div>
        </div>
    </div>
</section>
