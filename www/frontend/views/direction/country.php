<?php
/** @var array $seoData */
/** @var string $filterBackground */
/** @var string $h1 */
/** @var array $sectionTitle1 */
/** @var array $hotToursTitle */
/** @var array $bestResortsTitle */
/** @var array $resorts */
/** @var array $tabInformationTitle */
/** @var array $tabInformation */
/** @var array $formTitle */
/** @var array $blogTitle */
/** @var array $blogRecords */
/** @var array $seoTextTitle */

/** @var string $seoText */
use backend\modules\blog\helpers\DateHelper;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\filter\widgets\filter\FilterWidget;
use backend\modules\request\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $seoData['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $seoData['description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoData['keywords']]);
?>

<section class="section-presentation position-relative">
    <div class="search-section search-counties-section d-flex flex-column align-items-center pt-0"
         style="background: url('/admin<?= $filterBackground ?>') center / cover no-repeat;">
        <div class="container mb-auto">
            <div class="row">
                <div class="col-md-12">
                    <?= (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
                </div>
            </div>
        </div>
        <div class="filter-form-wrapper w-100 mb-auto">
            <h1 class="filter-form-wrapper--header text-center text-white d-none d-md-block"><?= $h1 ?></h1>
            <?= FilterWidget::widget(['alias' => 'default']) ?>
        </div>
    </div>
</section>

<?php if(!empty($recommend_tour)) : ?>
<section class="section section-ocean-recommends">
    <div class="container">
        <div class="section-header header-text-left left-offset-3 line-bottom" id="line-1">
            <div class="row">
                <div class="col-9 offset-md-2 header-title" id="animate1">
                    <h2 class="header-title__title">
                        <span class="header-title__text"><?= $sectionTitle1['row_1'] ?></span><?= $sectionTitle1['row_2'] ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container container-lg-mw swiper-container recommends-container">
        <div class="row-cards flex-lg-wrap swiper-wrapper">
            <?php foreach ($recommend_tour as $key => $item): ?>
                <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                    <div class="card card-size-s mb-0 mt-0">
                        <div class="card-header">
                            <a href="<?php echo $item['link']; ?>" target="_blank">
                                <div class="card-header--image preloader-inner">
                                    <img src="/admin/<?= $item['hotel']['media']['url']; ?>" alt="<?php echo $item['hotel']['media']['alt']; ?>">
                                    <div class="card-header--icons blog-left--menu d-lg-none">
                                        <div class="blog-left-menu__item active">
                                            <span><i class="icon-other icon-flame"></i></span>
                                        </div>
                                    </div>
                                    <div class="card-header--common">
                                        <?php if (isset($item['hotel']['review'][$item['hotel']['id']]['avg'])) : ?>
                                            <div class="card--rating text-white font-montserrat font-size-s">
                                                <span><strong><?php echo $item['hotel']['review'][$item['hotel']['id']]['avg']; ?></strong> оценка</span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($item['hotel']['review'][$item['hotel']['id']]['count'])) : ?>
                                            <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                                <span><strong><?php echo $item['hotel']['review'][$item['hotel']['id']]['count']; ?></strong> </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="<?php echo $item['link']; ?>"
                                   target="_blank"><span class="text-uppercase"><?php echo $item['hotel']['countries']['name']; ?> </span><?php echo $item['hotel']['cites']['name']; ?> </a>
                                   <!--<i class="icon icon-map"></i>-->
                            </div>
                            <div class="card-body--hotel d-flex align-items-center">
                                <h5><?php echo $item['hotel']['name'] . ' ' . $item['hotel']['category']['name']; ?></h5>
                            </div>
                            <h6 class="card-body--desc desc-fade">
                                <?php echo $item['description']; ?>
                            </h6>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo $item['link']; ?>" target="_blank"
                               class="btn-regular btn-size-m button-isi">Подробнее</a>
                            <div class="card-footer--prices">
                                <!--<h6 class="full-price"></h6>-->
                                <h2 class="descount-price">
                                    <small>от </small><?php echo number_format($item['price'], 2, '.', ' ') . ' ₴'; ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="d-block d-lg-none">
            <div class="swiper-pagination swiper-bottom-blog-pagination pagination-v1 w-100"></div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if(!empty($hot_tour)) : ?>
<section class="section section-ocean-recommends grey-bg">
    <div class="container">
        <div class="section-header header-text-right active line-bottom" id="line-2">
            <div class="row">
                <div class="offset-2 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title active"
                     id="animate2">
                    <h2 class="header-title__title grey-bg">
                        <span class="header-title__text"><?= $hotToursTitle['row_1'] ?></span> <?= $hotToursTitle['row_2'] ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container container-lg-mw swiper-container hot-resort-slider">
        <div class="row-cards flex-lg-wrap swiper-wrapper">
            <?php foreach ($hot_tour as $key => $item): ?>
                <div class="col-md-6 col-lg-6 col-xl-4 swiper-slide pb-3">
                    <div class="card card-size-s mb-0 mt-0">
                        <div class="card-header">
                            <a href="<?php echo $item['link']; ?>" target="_blank">
                                <div class="card-header--image preloader-inner">
                                    <img src="/admin/<?= $item['hotel']['media']['url']; ?>" alt="<?php echo $item['hotel']['media']['alt']; ?>">
                                    <div class="card-header--icons blog-left--menu d-lg-none">
                                        <div class="blog-left-menu__item active">
                                            <span><i class="icon-other icon-flame"></i></span>
                                        </div>
                                    </div>
                                    <div class="card-header--common">
                                        <?php if (isset($item['hotel']['review'][$item['hotel']['id']]['avg'])) : ?>
                                            <div class="card--rating text-white font-montserrat font-size-s">
                                                <span><strong><?php echo $item['hotel']['review'][$item['hotel']['id']]['avg']; ?></strong> оценка</span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($item['hotel']['review'][$item['hotel']['id']]['count'])) : ?>
                                            <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                                <span><strong><?php echo $item['hotel']['review'][$item['hotel']['id']]['count']; ?></strong> </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-body--region d-flex">
                                <a href="<?php echo $item['link']; ?>"
                                   target="_blank"><span class="text-uppercase"><?php echo $item['hotel']['countries']['name']; ?> </span><?php echo $item['hotel']['cites']['name']; ?> </a>
                                   <!--<i class="icon icon-map"></i>-->
                            </div>
                            <div class="card-body--hotel d-flex align-items-center">
                                <h5><?php echo $item['hotel']['name'] . ' ' . $item['hotel']['category']['name']; ?></h5>
                            </div>
                            <h6 class="card-body--desc desc-fade">
                                <?php echo $item['description']; ?>
                            </h6>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo $item['link']; ?>" target="_blank"
                               class="btn-regular btn-size-m button-isi">Подробнее</a>
                            <div class="card-footer--prices">
                                <!--<h6 class="full-price"></h6>-->
                                <h2 class="descount-price">
                                    <small>от </small><?php echo number_format($item['price'], 2, '.', ' ') . ' ₴'; ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="d-block d-lg-none">
            <div class="swiper-pagination swiper-bottom-blog-pagination pagination-v2 w-100"></div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($resorts[0]['photo'] != '') : ?>
<section class="section section-best-resort pb-0">
    <div class="container">
        <div class="section-header header-text-left left-offset-3" id="line-3">
            <div class="row">
                <div class="col-12 offset-md-0 offset-lg-2 header-title active" id="animate3">
                    <h2 class="header-title__title">
                        <span class="header-title__text"><?= $bestResortsTitle['row_1'] ?></span><?= $bestResortsTitle['row_2'] ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="swiper-container country-resorts">
        <div class="swiper-wrapper country-resorts--wrapper flex-md-wrap">

<!--            <div class="grid-sizer"></div>-->

            <?php
            $gridConfig = array(
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item',
                'swiper-slide country-resorts--item'
            );
            if ($resorts && !empty($resorts)) :
                for ($i = 0; $i < count($resorts); $i++) :
                    ?>
                    <div class="<?= $gridConfig[$i] ?>">
                        <?= Mediafile::getThumbnailById($resorts[$i]['photo'], 'original') ?>
                        <div class="country-resorts--item__info d-flex flex-column justify-content-end">
                            <h2 class="text-white"><?= $resorts[$i]['title'] ?></h2>
                            <p class="text-white"><?= $resorts[$i]['description'] ?></p>
                            <h5 class="text-white">
                                <small>от</small>
                                <?= $resorts[$i]['price'] ?> $ <span class="font-weight-normal">за одного</span></h5>
                        </div>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>

        <div class="swiper-pagination swiper-bottom-blog-pagination pagination-v3 w-100"></div>
    </div>
</section>
<?php endif; ?>

<?php if ($tabInformation[0]['title'] != '') : ?>
    <section class="section section-useful-info grey-bg">
        <div class="container">
            <div class="section-header header-text-left left-offset-3 line-bottom" id="line-4">
                <div class="row">
                    <div class="col-9 offset-md-0 offset-lg-2 header-title active" id="animate4">
                        <h2 class="header-title__title grey-bg">
                            <span class="header-title__text"><?= $tabInformationTitle['row_1'] ?></span> <?= $tabInformationTitle['row_2'] ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="useful-information">
                <div class="filter-buttons d-flex flex-wrap flex-column flex-lg-row">
                    <?php for ($i = 0; $i < count($tabInformation); $i++) : ?>
                        <button type="button" class="btn-filter <?= $i == 0 ? 'active' : '' ?>">
                            <?= $tabInformation[$i]['title'] ?>
                        </button>
                    <?php endfor; ?>
                </div>

                <div class="useful-information-block">
                    <?php for ($i = 0; $i < count($tabInformation); $i++) : ?>
                        <div class="current-tour--body clearfix <?= $i == 0 ? 'active' : '' ?>">
                            <?php if ($tabInformation[$i]['photo'] != '') : ?>
                                <?= Mediafile::getThumbnailById($tabInformation[$i]['photo'], 'original'); ?>
                            <?php endif; ?>
                            <div class="text-content">
                                <?= $tabInformation[$i]['description']; ?>
                            </div>

                            <!-- TODO: check for chars length -->
                            <button type="button" class="text-uppercase btn-regular btn-size-m button-isi btn-expand-info mt-4 mx-auto d-md-none">Показать еще</button>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="section section-tour-application">
    <div class="container">
        <div class="section-header header-text-right w-b-150 header-text_white line-bottom" id="line-5">
            <div class="row">
                <div class="offset-md-4 offset-lg-3 col-12 col-md-8 col-lg-6 header-title active" id="animate5">
                    <h2 class="header-title__title">
                        <span class="header-title__text"><?= $formTitle['row_1'] ?></span><?= $formTitle['row_2'] ?>
                    </h2>
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

<?php if (!empty($blogRecords) && count($blogRecords) > 2) : ?>
    <section class="section section-ocean-recommends grey-bg">
        <div class="container">
            <div class="section-header header-text-right active line-bottom" id="line-6">
                <div class="row">
                    <div class="offset-1 offset-md-4 offset-lg-6 col-11 col-md-8 col-lg-6 header-title active"
                         id="animate6">
                        <h2 class="header-title__title grey-bg">
                            <span class="header-title__text"><?= $blogTitle['row_1'] ?></span> <?= $blogTitle['row_2'] ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container container-lg-mw">
            <div class="swiper-container swiper-blog-container card-swiper-blog-container pt-3">
                <div class="swiper-wrapper swiper-blog--container_wrapper">
                    <?php foreach ($blogRecords as $post) : ?>
                        <div class="swiper-slide card-blog-bottom margin-b-30">
                            <div class="card card-size-s card-blog">
                                <div class="card-header">
                                    <div class="card-header--image">
                                        <?= Mediafile::getThumbnailById($post['media_id'], 'original') ?>
                                        <div class="card-header--common">
                                            <div class="card-blog--title text-white font-montserrat font-size-s">
                                                <p><?= $post['title'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body--region d-flex">
                                        <span class="blog-date"><?= DateHelper::dateFrontend($post['published_at']) ?></span>
                                        <span class="blog-views"><i class="icon-other icon-eye"></i><?= $post['views'] ?></span>
                                    </div>
                                    <h6 class="card-body--desc"><?= $post['description'] ?></h6>
                                </div>
                                <div class="card-footer">
                                    <?= Html::a('Подробнее', Url::toRoute(['blog/post/' . $post['alias']], true), ['class' => 'no-btn']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="visible-1199">
                    <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="section section-ocean-recommends">
    <div class="container">
        <div class="section-header header-text-left left-offset-3 line-bottom" id="line-7">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-1 header-title active" id="animate7">
                    <h2 class="header-title__title">
                        <span class="header-title__text"><?= $seoTextTitle['row_1'] ?></span><?= $seoTextTitle['row_2'] ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="ways-seo-wrapper">
            <?= $seoText ?>
        </div>
    </div>
</section>
