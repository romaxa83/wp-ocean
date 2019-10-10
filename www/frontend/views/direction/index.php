<?php

/** @var array $seoData */
/** @var array $h1 */
/** @var array $sectionTitle2 */
/** @var array $sectionTitle3 */
/** @var array $sectionTitle4 */
/** @var array $cards */
/** @var array $popularCountries */
/** @var array $categories */
/** @var string $channelId */
/** @var string $sectionContent3 */

use backend\modules\filemanager\models\Mediafile;
use backend\modules\request\models\Request;
use yii\helpers\Url;

$this->title = $seoData['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $seoData['description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoData['keywords']]);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?= (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
        </div>
    </div>
</div>

<section class="section section-ways-map">
    <div class="container">
        <div class="section-header header-text-left left-offset-6" id="line-1">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-5 header-title active" id="animate1">
                    <h2 class="header-title__title"><span class="header-title__text"><?= $h1['row_1'] ?></span><?= $h1['row_2'] ?></h2>
                </div>
            </div>
        </div>

        <div id="w-map" class="d-none d-lg-block"></div>

    </div>
</section>

<section class="section section-ways-cards py-0">
    <div class="container">
        <div class="ways-map">
            <div id="category-buttons" data-channel="<?= $channelId ?>" class="d-flex ways-btns-wrapper flex-wrap flex-lg-nowrap justify-content-center justify-content-lg-center">
                <?php foreach($categories as $category) : ?>
                    <button class="btn-filter btn-filter-type btn-size-xl btn-filter-map <?= $category['id'] == 0 ? 'active' : '' ?>"
                            data-cat="<?= $category['id'] ?>"
                            data-countries='<?= json_encode($category['countries']) ?>'
                    >
                        <?= $category['title'] ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="grey-bg pb-150px">
        <div class="container container-lg-mw">
            <div class="swiper-container ways-slider">
                <div id="region-countries" class="swiper-wrapper flex-lg-wrap">
                    <?php if(isset($cards['cards'])) : ?>
                    <?php foreach($cards['cards'] as $card) : ?>
                        <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
                            <div class="card card-size-s mb-0">
                                <div class="card-header">
                                    <a href="<?= $card['url'] ?>">
                                        <div class="card-header--image preloader-inner"><?= Mediafile::getThumbnailById($card['cover_id'], 'original') ?></div>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="card-body--region d-flex">
                                        <a href="<?= $card['url'] ?>">
                                            <span class="text-uppercase"><?= $card['name'] ?></span>
                                        </a>
                                    </div>
                                    <div class="card-body--desc">
                                        <p><?= $card['cities'] ?></p>
                                        <a href="<?= $card['url'] ?>" class="ways-read-more">Еще</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <?php $this->render('no-countries'); ?>
                    <?php endif; ?>
                </div>

                <div class="d-block d-lg-none mt-4">
                    <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
                </div>
            </div>
            <?php $loadMoreClass = $cards['pageCount'] > 1 ? '' : 'hidden'; ?>
            <div id="load-more" class="col-md-12 d-none d-lg-block <?= $loadMoreClass ?>">
                <button id="load-more-button" class="btn btn-regular btn-shadow button-isi btn-size-l ml-auto mr-auto">больше стран</button>
            </div>
        </div>
    </div>
</section>

<section class="section section-tour-application">
    <div class="container">
        <div class="section-header header-text-right w-b-150 header-text_white line-bottom" id="line-4">
            <div class="row">
                <div class="offset-md-4 offset-lg-3 col-12 col-md-8 col-lg-6 header-title active" id="animate4">
                    <h2 class="header-title__title"><span class="header-title__text"><?= $sectionTitle2['row_1'] ?></span><?= $sectionTitle2['row_2'] ?></h2>
                </div>
            </div>
        </div>

        <div class="tour-application--form">
            <form id="request-random-tour" action="<?= Url::to('/tour/save-request', TRUE) ?>" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group-white col-md-12 d-flex flex-wrap justify-content-between">
                        <input type="hidden" name="type" value="<?= Request::TYPE_DIRECTIONS ?>">
                        <div class="form-group required-input">
                            <input type="text" placeholder="Ваше имя" name="name">
                        </div>
                        <div class="form-group required-input">
                            <input type="tel" placeholder="Ваш телефон" name="phone">
                        </div>
                        <div class="form-group required-input">
                            <input type="email" placeholder="Ваш e-mail" name="email">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-regular btn-size-m button-isi">отправить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section section-seo">
    <div class="container">
        <div class="section-header header-text-left left-offset-3" id="line-2">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-1 header-title active" id="animate2">
                    <h1 class="header-title__title">
                        <span class="header-title__text"><?= $sectionTitle3['row_1'] ?></span><?= $sectionTitle3['row_2'] ?>
                    </h1>
                </div>
            </div>
        </div>

        <div class="ways-seo-wrapper">
            <?= $sectionContent3 ?>
        </div>
    </div>
</section>

<?php if(! empty($popularCountries['cards'])) : ?>
<section class="section section-popular-places grey-bg">
    <div class="container">
        <div class="section-header header-text-right line-bottom" id="line-3">
            <div class="row">
                <div class="offset-1 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title active" id="animate3">
                    <h2 class="header-title__title">
                        <span class="header-title__text"><?= $sectionTitle4['row_1'] ?></span> <?= $sectionTitle4['row_2'] ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($popularCountries['cards'])) : ?>
    <div class="container container-lg-mw">
        <div class="swiper-container slider-popular-places">
            <div class="swiper-wrapper">
                <?php foreach($popularCountries['cards'] as $country) : ?>
                    <div class="swiper-slide">
                        <div class="card card-size-s mb-0">
                            <div class="card-header">
                                <a href="<?= $country['url'] ?>">
                                    <div class="card-header--image preloader-inner">
                                        <?= Mediafile::getThumbnailById($country['cover_id'], 'original') ?>
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-body--region d-flex">
                                    <a href="<?= $country['url'] ?>">
                                        <span class="text-uppercase"><?= $country['name'] ?></span>
                                    </a>
                                </div>
                                <div class="card-body--desc">
                                    <p><?= $country['cities'] ?></p>
                                    <a href="<?= $country['url'] ?>" class="ways-read-more">Еще</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
        </div>
    </div>
    <?php endif; ?>
</section>
<?php endif; ?>
<?php
$this->registerJs('window.countryCodes = ' . $countryCodes, \yii\web\View::POS_BEGIN);
?>
