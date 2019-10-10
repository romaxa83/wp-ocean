<?php

use backend\modules\filemanager\models\Mediafile;
use yii\helpers\Html;

/** @var array $page */

$this->title = $page['pageMetas']['title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page['pageMetas']['description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page['pageMetas']['keywords']]);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
        </div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="section-header header-text-left active">
            <div class="row">
                <div class="offset-1 col-10 header-title active">

                    <h1 class="header-title__title"><span class="header-title__text">О нашей</span> компании</h1>
                </div>
            </div>
        </div>
        <div class="seo-wrapper full-text">
            <?= Html::decode($page['pageText']['description']['text']) ?>
        </div>
    </div>
</section>
<div class="team-section">
    <!--    <div class="container team-btns-wrapper ">
            <div class="d-flex justify-content-center align-items-center flex-wrap">
                <button class="btn-filter btn-filter-type btn-size-xl active">Наша команда</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Миссия и ценности</button>
                <button class="btn-filter btn-filter-type btn-size-xl">Награды и достижения</button>
            </div>
        </div>-->
    <div class="team">
        <div class="container">
            <div class="swiper-container team-slider ">
                <div class="swiper-wrapper flex-lg-wrap">
                    <?php $team = unserialize($page['pageText']['team']['text']); ?>
                    <?php foreach ($team as $person) : ?>
                        <div class="swiper-slide team__item col-12 col-md-6 col-lg-4 col-xl-3 text-center">
                            <div class="team__img">
                                <?= Mediafile::getThumbnailById($person['photo'], 'original') ?>
                            </div>
                            <div class="team__text">
                                <h6 class="team__title"><?= $person['name'] ?></h6>
                                <p class="team__description"><?= $person['description'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>