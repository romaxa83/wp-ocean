<?php

use yii\helpers\StringHelper;
use backend\modules\user\helpers\DateFormat;
use backend\modules\blog\helpers\ImageHelper;

/* @var $reviews */
?>
<?php if($reviews):?>
<section class="section section-testimonials">
    <div class="testimonials">
        <div class="container">
            <div class="section-header header-text-right header-text_white" id="line-6">
                <div class="row">
                    <div class="offset-1 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title" id="animate6">
                        <span class="header-title__text">отзывы наших</span>
                        <h2 class="header-title__title">клиентов</h2>
                    </div>
                </div>
            </div>
            <div class="swiper-container testimonial-container">
                <div class="swiper-wrapper">

                    <?php foreach ($reviews as $review):?>
                        <div class="swiper-slide">
                            <div class="testimonial-col">
                                <div class="testimonial--image">
                                <?= $review->user->media_id != null
                                    ? ImageHelper::getAvatar($review->user->media_id,true)
                                    : ImageHelper::notAvatar(true) ?>
                                </div>
                            <div class="testimonial--name">
                                <h2><?= $review->user->getFullName()?></h2>
                            </div>
                            <div class="testimonial--rating">
                                <?php for ($i=0 ; $i < $review->rating;$i++):?>
                                    <span><i class="icon icon-star active"></i></span>
                                <?php endfor;?>
                            </div>
                            <div class="testimonial--message">
                                <p><?= StringHelper::truncateWords($review->text,20)?></p>
                            </div>
                            <div class="testimonial--date">
                                <p><?= DateFormat::viewTimestampDate($review->created_at,'dot')?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
            </div>
            <div class="swiper-pagination testimonial-pagination"></div>
        </div>
            <div class="row row-btn-trigger">
                <div class="col-md-12">
                    <a href="#" class="btn-regular btn-size-m button-isi ml-auto mr-auto btn-animate-testimonial">все отзывы</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif;?>