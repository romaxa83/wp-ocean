<?php

use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\helpers\HotelHelper;
use backend\modules\blog\helpers\ImageHelper;
use backend\modules\blog\helpers\ReviewsHelper;
use frontend\helpers\PriceHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/** @var $hotelReview backend\modules\blog\entities\HotelReview*/
/** @var $tourHotel */
/** @var $tourOffers */
/** @var $dataApi */
/** @var $allRoom */
/** @var $typeFood */
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
        </div>
    </div>
</div>
<div class="hotel-wrapper">
    <div class="container">
        <div class="section-header header-text-right customized-header line-bottom" id="line-1">
            <div class="row">
                <div class="offset-1 offset-md-3 offset-lg-4 col-11 col-md-9 col-lg-8 header-title text-right"
                     id="animate1">
                    <h1 class="header-title__title">"<?= $hotelReview->title?>"</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="hotel">
        <div class="container">
            <div class="hotel-gallery">
                <div class="row">
                    <div class="col-md-12">
                        <div class="thumbnail-slider hotel-thumbnail-slider">
                            <?php if(ImageHelper::parseMediaIds($hotelReview->media_ids)):?>
                                <div class="swiper-container gallery-top">
                                    <div class="swiper-wrapper">
                                        <?php foreach(ImageHelper::getImageUrlsByIds(ImageHelper::parseMediaIds($hotelReview->media_ids)) as $id => $media):?>
                                            <div class="swiper-slide active">
                                                <a href="<?= $media['url'] ?>"
                                                   data-fancybox="gallery"
                                                   data-type="image"
                                                >
                                                    <img src="<?= $media['url'] ?>"
                                                         alt="<?= $media['alt'] ?>"
                                                         title="<?= $media['title'] ?>">
                                                </a>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            <?php else:?>
                                <div class="swiper-container gallery-top">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide active">
                                            <img src="<?=Url::base(true) . ImageHelper::notImg(true)?>" alt="not-images.png">
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                            <?php if(ImageHelper::parseMediaIds($hotelReview->media_ids)):?>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper can-swipe">
                                    <?php foreach(ImageHelper::getImageUrlsByIds(ImageHelper::parseMediaIds($hotelReview->media_ids)) as $id => $media):?>
                                        <div class="swiper-slide <?=$media['class']?>"
                                             data-src="<?= $media['url'] ?>"
                                             data-index="<?= $id ?>">
                                            <img src="<?= $media['url'] ?>"
                                                 alt="<?= $media['alt'] ?>"
                                                 title="<?= $media['title'] ?>">
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hotel-tags-wrapper align-items-baseline flex-wrap">
                <div class="hotel-date-view d-flex">
                    <span class="blog-date"><?= DateHelper::dateFrontend($hotelReview->published_at)?></span>
                    <span class="blog-views font-size-s"> <i class="icon-other icon-eye"></i><?= $hotelReview->views?></span>
                </div>
                <div class="blog-left--tags">
                    <div class="tags-row">
                        <?php foreach($hotelReview->tags as $tag):?>
                            <span class="tag-row--item"><?= $tag->title?></span>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>

            <div class="hotel-description"><?= $hotelReview->content?></div>

            <?php if($hotelReview->hotel->hotelService):?>
            <div class="popular-services">
                <div class="row">
                    <div class="col-12">
                        <h2 class="block-header">
                            Самые популярные услуги
                        </h2>
                    </div>
                </div>
                <div class="hotel-services">
                    <?php foreach ((new HotelHelper())->getPrettyServices($hotelReview->hotel->hotelService) as $name => $service):?>
                    <div class="hotel-service">
                        <h6 class="hotel-service__title"><?= $name;?></h6>
                        <ul class="hotel-service__list">
                            <?php foreach($service as $item):?>
                                <li class="hotel-service__item"><?= $item; ?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <section class="section find-tour-form grey-bg">
        <?= $this->render('_hr_request_tour')?>

        <?= $this->render('_hr_filter',[
            'hotelReview' => $hotelReview,
            'dataApi' => $dataApi,
            'tourOffers' => $tourOffers,
            'allRoom' => $allRoom,
            'typeFood' => $typeFood
        ])?>
    </section>
<?php if(!empty($hotelReview->hotel->reviews)):?>
    <?= $this->render('_hr_reviews',[
        'hotelReview' => $hotelReview,
        'reviewHelper' => new ReviewsHelper()
    ])?>
<?php endif;?>
<?php if($tourHotel && count($tourHotel) === 3):?>
    <?= $this->render('_hr_similar_tour',[
        'tourHotel' => $tourHotel,
        'reviewHelper' => new ReviewsHelper()
    ])?>
<?php endif;?>
</div>
