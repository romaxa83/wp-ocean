<?php

use backend\modules\filemanager\models\Mediafile;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $content */
/** @var array $h1 */
/** @var array $sectionTitle3 */
/** @var array $sectionTitle4 */
/** @var array $vacancies */
/** @var array $seoData */

$this->title = $seoData['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $seoData['description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoData['keywords']]);
?>

<div class="breadcrumb-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
            </div>
        </div>
    </div>
</div>

<div class="head-wrap to-left section">
    <div class="section-header header-text-left" id="line-1">
        <div class="container">
            <div class="row">
                <div class="col-12 header-title" id="animate1">
                    <div class="title-wrap">
                        <h1 class="header-title__title"> <span class="header-title__text text-right pr-0"><?= $h1['row_1'] ?></span><?= $h1['row_2'] ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="vacancy-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                <?= Html::decode($content['description_part_1']['content']) ?>
            </div>
            <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                <?= Html::decode($content['description_part_2']['content']) ?>
            </div>
            <div class="col-12 text-center action-content">
                <a href="#vacancy_anchor" rel="nofollow" class="btn-regular button-isi btn-size-m">вакансии</a>
            </div>
        </div>
    </div>
</div>

<!-- NOTE Swiper layout -->
<div id="vacancy" class="slider-content vacancy">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php $cards = unserialize($content['cards']['content']); ?>
                        <?php foreach ($cards as $card) : ?>
                            <div class="swiper-slide">
                                <div class="slide-wrap d-flex flex-column">
                                    <div class="item-img">
                                        <?= Mediafile::getThumbnailById($card['photo'], 'original') ?>
                                    </div>
                                    <div class="item-content d-flex flex-column">
                                        <h3 class="content-title"><?= $card['title'] ?></h3>
                                        <div class="content-text seo-wrapper-v2"><?= $card['description'] ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="facts-section section section-counter">
    <div class="facts-description non-wrap section-header header-text-left" id="line-2">
        <div class="container">
            <div class="row">
                <div class="col-12 header-title active helper-control" id="animate">
                    <div class="helper-wrap">
                        <h2 class="header-title__title"> <span class="header-title__text"><?= $sectionTitle3['row_1'] ?></span><?= $sectionTitle3['row_2'] ?></h2>
                        <button type="button" data-toggle="modal" data-target="#modal-join-us" class="btn-regular button-isi btn-size-m">присоединиться</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="facts" class="slider-content facts counter">
        <?php $facts = unserialize($content['facts']['content']); ?>
        <div class="swiper-container container counter-container v2">
            <div class="swiper-wrapper flex-sm-wrap">
                <?php foreach($facts as $fact) : ?>
                    <div class="swiper-slide col-xs-12 col-sm-6 col-md-6 col-xl-3 counter-col">
                        <div class="slide-wrap">
                            <div class="counter-col--header" data-num="<?= $fact['value'] ?>">0</div>
                            <div class="slide-content">
                                <p><?= $fact['description'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<div class="head-wrap v2 blue to-left section" id="vacancy_anchor">
    <div class="section-header header-text-left" id="line-3">
        <div class="container">
            <div class="row">
                <div class="col-12 header-title" id="animate3">
                    <div class="title-wrap">
                        <h2 class="header-title__title"> <span class="header-title__text pr-0"><?= $sectionTitle4['row_1'] ?></span><?= $sectionTitle4['row_2'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($vacancies)) : ?>
<div id="vacancy2" class="slider-content vacancy v2">
    <div class="container">
        <div class="swiper-container swiper-container-vacancy2">
            <div class="swiper-wrapper flex-lg-wrap">
                <?php foreach ($vacancies as $vacancy) : ?>
                    <div class="swiper-slide">
                        <div class="slide-wrap">
                            <div class="item-content d-flex flex-column">
                                <h3 class="content-title"><?= $vacancy['title'] ?></h3>
                                <div class="content-text mb-3">
                                    <div class="text-wrap-line-4">
                                    <?= Html::decode($vacancy['channelRecordContent']['description_part_1']['content']) ?>
                                    </div>
                                    <p><b>Опыт
                                            работы:</b> <?= $vacancy['channelRecordContent']['experience']['content'] ?>
                                    </p>
                                </div>
                                <div class="flex-fill d-flex align-items-end">
                                    <a
                                            href="<?= Url::to(['vacancy/view', 'template' => 'vacancy-view', 'post_id' => $vacancy['id']]) ?>"
                                            class="btn-regular button-isi btn-size-m"
                                    >Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
<?php endif; ?>