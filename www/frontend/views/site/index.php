<?php
/* @var $this yii\web\View */
/* @var array $seoData */
/* @var array $content */

use backend\modules\blog\widgets\post\PostWidget;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\staticBlocks\widget\StaticBlocksWidget;
use backend\modules\user\widgets\reviews\ReviewsWidget;
use yii\helpers\Url;
use frontend\components\Helpers;
use backend\modules\filter\widgets\filter\FilterWidget;

$this->title = $seoData['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $seoData['description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoData['keywords']]);
?>


<!-- *** Section main screen search *** -->
<section class="section section-search animation-on">
    <?php
    $banners = unserialize($content['banners']['text']);
    $icons = array(
        '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <g>
                                <g>
                                    <path class="st0" d="M445.3,310.9c-3.6-7.2-11-11.8-19.1-11.8c-8.1,0-15.5,4.6-19.1,11.8l-46.2,92.3L210,139.3
                                          c-0.1-0.1-0.2-0.2-0.3-0.4c-0.9-1.5-1.9-2.8-3.1-4c-0.2-0.2-0.4-0.3-0.6-0.5c-1-1-2.1-1.8-3.3-2.5c-0.5-0.3-0.9-0.5-1.4-0.8
                                          c-1.1-0.6-2.2-1-3.4-1.4c-0.4-0.1-0.9-0.3-1.3-0.4c-1.6-0.4-3.3-0.6-5-0.7c-0.1,0-0.2,0-0.2,0c-0.3,0-0.6,0.1-0.9,0.1
                                          c-1,0-1.9,0-2.9,0.2c-0.4,0.1-0.7,0.2-1.1,0.3c-0.5,0.1-1.1,0.3-1.6,0.4c-1.2,0.4-2.3,0.9-3.4,1.4c-0.4,0.2-0.8,0.4-1.2,0.6
                                          c-1.4,0.9-2.8,1.9-3.9,3c-0.2,0.2-0.3,0.4-0.5,0.5c-1,1.1-1.9,2.2-2.7,3.5c-0.1,0.2-0.3,0.4-0.4,0.6L2.3,437.9
                                          c-3.8,6.6-3.8,14.7,0.1,21.3c3.8,6.6,10.8,10.6,18.4,10.6h469.3c7.4,0,14.3-3.8,18.1-10.1c3.9-6.3,4.2-14.1,0.9-20.8L445.3,310.9z
                                          M88.1,373.8h39.4c11.8,0,21.3-9.6,21.3-21.3c0-11.8-9.6-21.3-21.3-21.3h-15l68.4-119.7l38.5,215.6H57.6L88.1,373.8z M262.7,427.1
                                          l-28.5-159.6l91.2,159.6H262.7z M396.7,427.1l29.5-59l29.5,59H396.7z M396.7,427.1" />
                                </g>
                                <path class="st0" d="M426.2,107.2c0-35.3-28.7-64-64-64s-64,28.7-64,64c0,35.3,28.7,64,64,64S426.2,142.5,426.2,107.2L426.2,107.2z
                                      M340.8,107.2c0-11.8,9.6-21.3,21.3-21.3c11.8,0,21.3,9.6,21.3,21.3c0,11.8-9.6,21.3-21.3,21.3C350.4,128.5,340.8,119,340.8,107.2
                                      L340.8,107.2z M340.8,107.2" />
                            </g>
                        </svg>',
        '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <g>
                                <path class="st0" d="M469.3,320v-85.3c0-23.5-19.1-42.7-42.7-42.7h-64v-21.3c0-51.5-36.7-94.6-85.3-104.5V21.3
                                      C277.3,9.6,267.8,0,256,0c-11.8,0-21.3,9.6-21.3,21.3v44.8c-48.6,9.9-85.3,53-85.3,104.5V192h-64c-23.5,0-42.7,19.1-42.7,42.7V320
                                      C19.1,320,0,339.1,0,362.7v128C0,502.4,9.6,512,21.3,512h469.3c11.8,0,21.3-9.6,21.3-21.3v-128C512,339.1,492.9,320,469.3,320
                                      L469.3,320z M426.7,234.7V320h-64v-85.3H426.7z M192,320v-64h128v64H192z M256,106.7c35.3,0,64,28.7,64,64v42.7H192v-42.7
                                      C192,135.4,220.7,106.7,256,106.7L256,106.7z M85.3,234.7h64V320h-64V234.7z M469.3,362.7v106.7H42.7V362.7H469.3z M469.3,362.7" />
                                <path class="st0" d="M128,437.3h10.7c11.8,0,21.3-9.6,21.3-21.3c0-11.8-9.6-21.3-21.3-21.3H128c-11.8,0-21.3,9.6-21.3,21.3
                                      C106.7,427.8,116.2,437.3,128,437.3L128,437.3z M128,437.3" />
                                <path class="st0" d="M245.3,437.3h21.3c11.8,0,21.3-9.6,21.3-21.3c0-11.8-9.6-21.3-21.3-21.3h-21.3c-11.8,0-21.3,9.6-21.3,21.3
                                      C224,427.8,233.6,437.3,245.3,437.3L245.3,437.3z M245.3,437.3" />
                                <path class="st0" d="M373.3,437.3H384c11.8,0,21.3-9.6,21.3-21.3c0-11.8-9.6-21.3-21.3-21.3h-10.7c-11.8,0-21.3,9.6-21.3,21.3
                                      C352,427.8,361.6,437.3,373.3,437.3L373.3,437.3z M373.3,437.3" />
                            </g>
                        </svg>',
        '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                            <g>
                                <path class="st0" d="M490.7,469.3h-31L385,352c-2.2-3.5-4.2-7.1-6.3-10.6h26.6c11.8,0,21.3-9.6,21.3-21.3
                                      c0-11.8-9.6-21.3-21.3-21.3h-49c-12.3-27.4-21.5-56-27.6-85.3H352c11.8,0,21.3-9.6,21.3-21.3c0-11.8-9.6-21.3-21.3-21.3h-29.6
                                      c-1.4-13.9-2.4-27.9-2.4-42v-22c0-11.8-9.6-21.3-21.3-21.3h-21.3v-64C277.3,9.6,267.8,0,256,0c-11.8,0-21.3,9.6-21.3,21.3v64h-21.3
                                      c-11.8,0-21.3,9.6-21.3,21.3v22c0,14.1-1,28.1-2.4,42H160c-11.8,0-21.3,9.6-21.3,21.3c0,11.8,9.6,21.3,21.3,21.3h23.2
                                      c-6.1,29.3-15.3,57.9-27.6,85.3h-49c-11.8,0-21.3,9.6-21.3,21.3c0,11.8,9.6,21.3,21.3,21.3h26.5c-2.1,3.5-4,7.2-6.3,10.6
                                      L52.3,469.3h-31C9.6,469.3,0,478.9,0,490.7C0,502.4,9.6,512,21.3,512h469.3c11.8,0,21.3-9.6,21.3-21.3
                                      C512,478.9,502.4,469.3,490.7,469.3L490.7,469.3z M234.7,128.7V128h42.7v0.7c0,14.1,0.9,28.1,2.2,42h-47
                                      C233.8,156.7,234.7,142.7,234.7,128.7L234.7,128.7z M226.5,213.3h58.9c5.5,29.2,13.8,57.7,24.8,85.3H201.7
                                      C212.8,271.1,221,242.5,226.5,213.3L226.5,213.3z M163,374.9c7-10.9,13.3-22.2,19.2-33.6h147.6c6,11.4,12.3,22.6,19.2,33.6
                                      l60.1,94.4h-72.5l-9.2-36.8c-7.1-28.6-32.6-48.5-62.1-48.5h-18.7c-29.4,0-55,19.9-62.1,48.5l-9.2,36.9h-72.5L163,374.9z
                                      M292.7,469.3h-73.3l6.6-26.5c2.4-9.5,10.9-16.2,20.7-16.2h18.7c9.8,0,18.3,6.6,20.7,16.2L292.7,469.3z M292.7,469.3" />
                            </g>
                        </svg>'
    );
    ?>
    <div class="header-tours col-12 d-flex d-lg-none">
        <div class="container">
            <div class="row">
                <?php foreach ($banners as $i => $banner) : ?>
                    <?php if (isset($banner['filter']) && !empty($banner['filter'])): ?>
                    <a href="<?= Url::to(((isset($filter[$banner['filter']]['alias'])) ? 'search/' . $filter[$banner['filter']]['alias'] : '/'), TRUE); ?>" class="col-4 header-tours__item">
                        <div class="header-tours__icon">
                            <?= $icons[$i] ?>
                        </div>
                        <?php $title = Helpers::getPartsOfTitle($banner['name']); ?>
                        <div class="header-tours__link"><span><?= $title['row_1'] ?></span> <?= $title['row_2'] ?></div>
                    </a>
                    <?php elseif (isset($banner['page']) && !empty($banner['page'])): ?>
                        <a href="<?= Url::to(((isset($pageData[$banner['page']]['slugManager']['slug'])) ? $pageData[$banner['page']]['slugManager']['slug'] : '/'), TRUE); ?>" class="col-4 header-tours__item">
                            <div class="header-tours__icon">
                                <?= $icons[$i] ?>
                            </div>
                            <?php $title = Helpers::getPartsOfTitle($banner['name']); ?>
                            <div class="header-tours__link"><span><?= $title['row_1'] ?></span> <?= $title['row_2'] ?></div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="search-images-wrapper swiper-container">
        <div class="d-flex d-lg-none main-screen-mob-bg">
            <img src="img/slider-images/mob_bg.png" alt="mob_bg" />
        </div>
        <div class="swiper-wrapper">
            <?php foreach ($banners as $i => $banner) : ?>
                <div class="search-image swiper-slide">
                    <div class="search-image__item">
                        <?php if (isset($banner['filter']) && !empty($banner['filter'])): ?>
                            <a href="<?= Url::to(((isset($filter[$banner['filter']]['alias'])) ? 'search/' . $filter[$banner['filter']]['alias'] : '/'), TRUE); ?>">
                        <?php elseif (isset($banner['page']) && !empty($banner['page'])): ?>
                            <a href="<?= Url::to(((isset($pageData[$banner['page']]['slugManager']['slug'])) ? $pageData[$banner['page']]['slugManager']['slug'] : '/'), TRUE); ?>">
                        <?php else: ?>
                            <a href="#">
                        <?php endif; ?>
                            <div class="search-image__item-img">
                                <?= Mediafile::getThumbnailById($banner['bluer'], 'original', ['class' => 'filter-blur']) ?>
                            </div>
                            <div class="search-image__item-img search-image__item-img_not-hover">
                                <?= Mediafile::getThumbnailById($banner['image'], 'original', ['class' => 'filter-blur']) ?>
                            </div>
                            <div class="search-image__item-text">
                                <div class="search-image__item-title"><?= $banner['name'] ?></div>
                                <div class="search-image__item-subtitle"><?= $banner['description'] ?></div>
                            </div>
                            </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <?php echo FilterWidget::widget(['alias' => 'default']); ?>
    </div>
</section>

<!-- *** Section promotional tours and top sales *** -->
<?php if (isset($top_tour) && count($top_tour) > 0): ?>
    <section class="section section-sales pb-0">
        <div class="container p-0">
            <div class="section-header header-text-right" id="line-1">
                <div class="row">
                    <div class="offset-1 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title" id="animate1">

                        <h2 class="header-title__title"><span class="header-title__text">Акционные туры и</span> Топ продаж</h2>
                                                                                               
                    </div>
                </div>
            </div>
            <div class="swiper-container sales-container">
                <div class="swiper-wrapper flex-lg-wrap">
                    <?php $hs = Yii::$app->params['hotel_service']; ?>
                    <?php foreach ($top_tour as $k => $v): ?>
                        <?php $img = @getimagesize(Url::to('/admin/' . $v['hotel']['media']['url'], TRUE)); ?>
                        <?php if ($k <= 1): ?>
                            <!-- card -->
                            <div class="swiper-slide col-xs-12 col-md-6 <?php echo ($k == 0) ? 'col-card-animate-1' : 'col-card-animate-2' ?>">
                                <div class="card card-size-m">
                                    <div class="card-header">
                                        <?php if (isset($v['special']['name'])) : ?>
                                            <div class="gallery-top--sales">
                                                <div class="gallery-top--sales__icon">
                                                    <object type="image/svg+xml" data="/img/pole.svg" width="90" height="25">
                                                        <img src="/img/pole.svg" width="90" height="25" alt="image format png"/>
                                                    </object>
                                                    <span class="svg-article">АКЦИЯ</span>
                                                </div>
                                                <div class="gallery-top--sales__note">
                                                    <p><?php echo $v['special']['name']; ?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <a href="<?php echo $v['link']; ?>" target="_blank">
                                            <div class="card-header--image preloader-inner">
                                                <?php if ($img): ?>
                                                    <img src="<?php echo Url::to('/admin/' . $v['hotel']['media']['url'], TRUE); ?>" alt="<?php echo $v['hotel']['media']['alt']; ?>" />
                                                <?php else : ?>
                                                    <img src="<?php echo Url::to('/admin/img/logo_no_photo.png', TRUE); ?>" alt="image not found or missed" class="img-not-found" />
                                                <?php endif; ?>
                                                <div class="card-header--common">
                                                    <?php if (isset($hotel_review[$v['hotel']['id']]['avg'])): ?>
                                                        <div class="card--rating text-white font-montserrat font-size-s">
                                                            <span><strong><?php echo $hotel_review[$v['hotel']['id']]['avg']; ?></strong> оценка</span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (isset($hotel_review[$v['hotel']['id']]['count'])) : ?>
                                                        <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                                            <span><strong><?php echo $hotel_review[$v['hotel']['id']]['count']; ?></strong></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (isset($v['hotel']['hotelService']) && count($v['hotel']['hotelService']) > 0): ?>
                                                        <div class="card--privileges ml-auto">
                                                            <?php foreach ($v['hotel']['mainService'] as $k1 => $v1): ?>
                                                                <?php if (isset($hs[$v1['code']])): ?>
                                                                    <div class="snap snap-size-xs d-flex align-items-center justify-content-center" data-toggle="tooltip" data-html="true" title="<?php echo $v1['name'] ?>">
                                                                        <object type="image/svg+xml" data="<?php echo Url::to('img/service_icon/' . $hs[$v1['code']], TRUE); ?>" width="20" height="20">
                                                                            <img src="<?php echo Url::to('img/service_icon/' . $hs[$v1['code']], TRUE); ?>" width="20" height="20" alt="image format png" />
                                                                        </object>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body--region d-flex">
                                            <a href="<?php echo $v['link']; ?>" target="_blank">
                                                <span class="text-uppercase"><?php echo $v['hotel']['countries']['name']; ?></span>
                                                <?php echo $v['hotel']['cites']['name']; ?>
                                            </a>
            <!--                                                                                            <i class="icon icon-map"></i>-->
                                        </div>
                                        <div class="card-body--hotel d-flex align-items-center">
                                            <div class="hotel-name"><?php echo $v['hotel']['name'] . ' ' . $v['hotel']['category']['name']; ?></div>
                                        </div>
                                        <div class="card-body--desc"><?php echo $v['description']; ?></div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?php echo $v['link']; ?>" target="_blank" class="btn-regular btn-size-m button-isi">Подробнее</a>
                                        <div class="card-footer--prices">
                                            <div class="descount-price"><small>от</small> <?php echo number_format($v['price'], 2, '.', ' ') . ' ₴'; ?></div>
                                            <!--<h6 class="full-price"><?php //echo number_format($v['price'], 2, '.', ' ') . ' ₴'; ?></h6>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- card -->
                            <div class="swiper-slide col-xs-12 col-md-6 col-xl-4">
                                <div class="card card-size-s card-animate-s">
                                    <div class="card-header">
                                        <?php if (isset($v['special']['name'])) : ?>
                                        <div class="gallery-top--sales">
                                            <div class="gallery-top--sales__icon">
                                                <object type="image/svg+xml" data="/img/pole.svg" width="90" height="25">
                                                    <img src="/img/pole.svg" width="90" height="25" alt="image format png"/>
                                                </object>
                                                <span class="svg-article">АКЦИЯ</span>
                                            </div>
                                            <div class="gallery-top--sales__note">
                                                <p><?php echo $v['special']['name']; ?></p>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <a href="<?php echo $v['link']; ?>" target="_blank">
                                            <div class="card-header--image preloader-inner">
                                                <?php if ($img): ?>
                                                    <img src="<?php echo Url::to('/admin/' . $v['hotel']['media']['url'], TRUE); ?>" alt="<?php echo $v['hotel']['media']['alt']; ?>" />
                                                <?php else : ?>
                                                    <img src="<?php echo Url::to('/admin/img/logo_no_photo.png', TRUE); ?>" alt="" class="img-not-found"/>
                                                <?php endif; ?>
                                                <div class="card-header--common">
                                                    <?php if (isset($hotel_review[$v['hotel']['id']]['avg'])) : ?>
                                                        <div class="card--rating text-white font-montserrat font-size-s">
                                                            <span><strong><?php echo $hotel_review[$v['hotel']['id']]['avg']; ?></strong> оценка</span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if (isset($hotel_review[$v['hotel']['id']]['count'])) : ?>
                                                        <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                                            <span><strong><?php echo $hotel_review[$v['hotel']['id']]['count']; ?></strong> </span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body--region d-flex">
                                            <a href="<?php echo $v['link']; ?>" target="_blank">
                                                <span class="text-uppercase"><?php echo $v['hotel']['countries']['name']; ?></span>
                                                <?php echo $v['hotel']['cites']['name']; ?>
                                            </a>
            <!--                                                                            <i class="icon icon-map"></i>-->
                                        </div>
                                        <div class="card-body--hotel d-flex align-items-center">
                                            <div class="hotel-name"><?php echo $v['hotel']['name'] . ' '. $v['hotel']['category']['name']; ?></div>
                                        </div>
                                        <div class="card-body--desc"><?php echo $v['description']; ?></div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?php echo $v['link']; ?>" target="_blank" class="btn-regular btn-size-m button-isi">Подробнее</a>
                                        <div class="card-footer--prices">
                                            <div class="descount-price"><small>от</small> <?php echo number_format($v['price'], 2, '.', ' ') . ' ₴'; ?></div>
                                            <!-- <h6 class="full-price"> <?php //echo number_format($v['price'], 2, '.', ' ') . ' ₴';           ?></h6> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-12 mt-5">
                <a href="<?php echo Url::to('/sale-tours', TRUE); ?>" class="btn-regular btn-size-m button-isi btn-shadow mx-auto mx-xl-0 ml-xl-auto">Смотреть все</a>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- *** Section Counter from 0 to some number *** -->
<?= StaticBlocksWidget::widget(['template' => 'counter']) ?>

<!-- *** Section Popular Post *** -->

<?= PostWidget::widget(['template' => 'popular']) ?>

<!-- *** Section Smart mailing *** -->
<?php //echo StaticBlocksWidget::widget(['template' => 'smart'])      ?>

<!-- *** Advantages Section *** -->

<?= StaticBlocksWidget::widget(['template' => 'advantage']) ?>


<!-- *** Section How we work *** -->
<!--                                                <section class="section section-work">
    <div class="container">
        <div class="section-header header-text-left" id="line-5">
            <div class="row">
                <div class="offset-1 col-11 header-title" id="animate5">
                    <span class="header-title__text">как мы</span>
                    <h2 class="header-title__title">работаем</h2>
                </div>
            </div>
        </div>
    </div>
</section>-->

<!-- *** Section Testimonials *** -->
<?= ReviewsWidget::widget(['template' => 'frontend-reviews']) ?>

<!-- *** Section information About Company *** -->
<?= StaticBlocksWidget::widget(['template' => 'company']) ?>

<!-- *** Section SEO *** -->
<?= StaticBlocksWidget::widget(['template' => 'seo']) ?>
