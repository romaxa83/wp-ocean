<?php

use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\helpers\ImageHelper;
use backend\modules\blog\helpers\TitleHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $post backend\modules\blog\entities\Post */
/** @var $postSeo backend\modules\blog\entities\Meta */
/** @var $similar_posts backend\modules\blog\entities\Post */

?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
            </div>
        </div>
    </div>
    <article class="section section-blog">
        <div class="container">
            <div class="section-header header-text-left customized-header active line-bottom" id="line-1">
                <div class="row">
                    <div class="col-12 header-title text-left active" id="animate1">
                        <h1 class="header-title__title text-transform-unset">
                            <?= TitleHelper::detDelivery($post->title)?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="article">
                <div class="article-img-wrapper">
                    <img src="<?= ImageHelper::frontendImg($post) ?>"
                         alt="<?= ImageHelper::getAltFront($post) ?>">
                </div>
                <div class="hotel-tags-wrapper justify-content-between flex-wrap">
                    <div class="hotel-date-view d-flex">
                        <span class="blog-date"><?= DateHelper::dateFrontend($post->published_at) ?></span>
                        <span class="blog-views"> <i class="icon-other icon-eye"></i><?= $post->views ?> </span>
                    </div>
                    <div class="blog-left--tags">
                        <div class="tags-row">
                            <?php foreach ($post->tags as $tag): ?>
                                <span class="tag-row--item"><?= $tag->title ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="article-text standart-list-li"><?= $post->content ?></div>
                <div class="d-flex justify-content-end align-items-center share">
                    <span class="font-weight-400 color-909090 font-size-s pr-2">Поделиться:</span>
                    <div class="d-flex">
                        <span style="cursor: pointer" title="facebook" data-init="facebook">
                            <img class="share--icon" src="<?= Url::base() . '../../img/icons/facebook-ico.png' ?>"
                                 alt="facebook-ico.png" width="39">
                        </span>
                        <span style="cursor: pointer" title="telegram" data-init="telegram">
                            <img class="share--icon" src="<?= Url::base() . '../../img/icons/telegram-ico.png' ?>"
                                 alt="telegram-ico.png" width="40">
                        </span>
                        <span style="cursor: pointer" title="skype" data-init="skype">
                            <img class="share--icon" src="<?= Url::base() . '../../img/icons/skype-ico.png' ?>"
                                 alt="skype-ico.png" width="40">
                        </span>
                        <span style="cursor: pointer" title="viber" data-init="viber">
                            <img class="share--icon" src="<?= Url::base() . '../../img/icons/viber-ico.png' ?>"
                                 alt="viber-ico.png" width="40">
                        </span>
                    </div>
                </div>
                <?php if ($post->country_id != null): ?>
                    <div class="text-center">
                        <?= Html::a("посмотреть туры в эту страну",
                            Url::toRoute(['/search/'.$post->country->alias],true), [
                                    'class' => 'btn-regular button-isi btn-shadow'
                            ]);?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </article>
<?php if ($similar_posts): ?>
    <section class="section section-blog grey-bg">
        <div class="container">
            <div class="section-header header-text-left left-offset-3" id="line-2">
                <div class="row">
                    <div class="col-12 col-md-8 offset-md-4 header-title" id="animate2">
                        <h2 class="header-title__title"><span class="header-title__text">Вас также могут</span>заинтересовать</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container container-md-mw">
            <div class="swiper-container swiper-blog-container card-swiper-blog-container pt-3">
                <div class="swiper-wrapper swiper-blog--container_wrapper">
                    <?php foreach ($similar_posts as $post): ?>
                        <div class="swiper-slide card-blog-bottom margin-b-30">
                            <div class="card card-size-s card-blog">
                                <div class="card-header">
                                    <div class="card-header--image">
                                        <img
                                                src="<?= ImageHelper::frontendImg($post) ?>"
                                                alt="<?= ImageHelper::getAltFront($post) ?>"
                                        >
                                        <div class="card-header--common">
                                            <div class="card-blog--title text-white font-montserrat font-size-s">
                                                <p><?= $post->title ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body--region d-flex">
                                        <span class="blog-date"><?= DateHelper::dateFrontend($post->published_at) ?></span>
                                        <span class="blog-views"><i class="icon-other icon-eye"></i><?= $post->views ?></span>
                                    </div>
                                    <h6 class="card-body--desc"><?= $post->description ?></h6>
                                </div>
                                <div class="card-footer">
                                    <?= Html::a('Подробнее', Url::toRoute(['blog/post/' . $post->alias],true), ['class' => 'no-btn']) ?>
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
