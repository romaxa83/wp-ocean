<?php

use yii\helpers\Url;
?>
<?php if (isset($similar_hotels) && count($similar_hotels) > 0): ?>
    <!-- *** Section promotional tours and top sales *** -->
    <section class="section section-sales">
        <div class="container">
            <div class="section-header header-text-left" id="line-3">
                <div class="row">
                    <div class=" col-12 header-title" id="animate3">

                        <h2 class="header-title__title"><span class="header-title__text">Вас также могут</span> заинтересовать</h2>
                    </div>
                </div>
            </div>
            <div class="row row-cards">
                <?php foreach ($similar_hotels as $k => $v): ?>
                    <?php if ($k <= 5): ?>
                        <?php $img = @getimagesize(Url::to('/admin/' . $v['media']['url'], TRUE)); ?>
                        <!-- card -->
                        <div class="col-xs-12 col-md-6 col-xl-4">
                            <div class="card card-size-s mb-0">
                                <div class="card-header">
<!--                                    <div class="gallery-top--sales">
                                        <div class="gallery-top--sales__icon">
                                            <object type="image/svg+xml" data="/img/pole.svg" width="90" height="25">
                                                <img src="/img/pole.svg" width="90" height="25" alt="image format png"/>
                                            </object>
                                            <span class="svg-article">АКЦИЯ</span>
                                        </div>
                                        <div class="gallery-top--sales__note">
                                            <p>Бесплатные ночи в подарок</p>
                                        </div>
                                    </div>-->
                                    <a href="<?php echo $v['link']; ?>" target="_blank">
                                        <div class="card-header--image preloader-inner">
                                            <?php if ($img): ?>
                                                <img
                                                    src="<?php echo (isset($v['media']['url'])) ? Url::to('/admin/' . $v['media']['url'], TRUE) : ''; ?>"
                                                    alt="<?php echo (isset($v['media']['alt'])) ? $v['media']['alt'] : '' ?>">
                                                <?php else: ?>
                                                <img src="<?php echo Url::to('/admin/img/logo_no_photo.png', TRUE); ?>" alt="" class="img-not-found" />
                                            <?php endif; ?>
                                            <div class="card-header--common">
                                                <?php if (isset($hotel_review[$v['id']]['avg'])): ?>
                                                    <div class="card--rating text-white font-montserrat font-size-s">
                                                        <span><strong><?php echo $hotel_review[$v['id']]['avg']; ?></strong> оценка</span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (isset($hotel_review[$v['id']]['count'])): ?>
                                                    <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                                        <span><strong><?php echo $hotel_review[$v['id']]['count']; ?></strong> </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="card-body--region d-flex">
                                        <a href="<?php echo $v['link']; ?>" target="_blank"><span
                                                class="text-uppercase"><?php echo $v['countries']['name']; ?> </span><?php echo $v['cites']['name']; ?>
                                        </a>
                                        <i class="icon icon-map"></i>
                                    </div>
                                    <div class="card-body--hotel d-flex align-items-center">
                                        <div><?php echo $v['name'] . ' ' . $v['category']['name']; ?></div>
                                    </div>
                                    <div class="card-body--desc desc-fade">
                                        <?php echo (isset($v['address']['general_description'])) ? $v['address']['general_description'] : ''; ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="<?php echo $v['link']; ?>" target="_blank" 
                                       class="btn-regular btn-size-m button-isi">Подробнее</a>
                                    <div class="card-footer--prices">
                                        <!-- <h6 class="full-price"><?php //echo $v['price'] . ' ₴';      ?></!-->
                                        <div class="descount-price">
                                            <small>от </small><?php echo number_format($v['price'], 2, '.', ' ') . ' ₴'; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
