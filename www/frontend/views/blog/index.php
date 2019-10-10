<?php

use backend\modules\blog\helpers\TitleHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\helpers\ImageHelper;

/** @var $posts backend\modules\blog\entities\Post*/
/** @var $tags backend\modules\blog\entities\Tag*/
/** @var $categories backend\modules\blog\entities\Category*/
/** @var $countries backend\modules\referenceBooks\models\Country*/
/** @var $hotels backend\modules\referenceBooks\models\Hotel*/
/** @var $all_posts_count */
/** @var $limit */
/** @var $route */

$this->title = 'Актуальные новости туристической компании "Пятый Океан"';
$this->registerMetaTag(['name' => 'description', 'content' => 'Блог туристической компании "Пятый Океан". Ознакомьтесь с текущими новостями компании, последними событиями в мире туризма и советами для путешествующих.']);
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo (isset(Yii::$app->view->params['breadcrumbs'])) ? Yii::$app->view->params['breadcrumbs'] : FALSE; ?>
        </div>
    </div>
</div>

<section class="section section-blog pb-150px">
    <div class="container container-md-mw">
        <div class="section-header header-text-left left-offset-3 line-bottom" id="line-1">
            <div class="row">
                <div class="col-9 offset-md-0 offset-lg-3 header-title" id="animate1">
                    <h1 class="header-title__title"><?= isset($title)?TitleHelper::detDelivery($title) :'<span class="header-title__text">Самый интересный</span> блог'?></h1>
                </div>
            </div>
        </div>

        <div class="blog">
            <div class="row">
                <aside class="col-sm-12 col-md-12 col-lg-4 col-xl-3 blog-left">
                    <?php if($categories):?>
                    <div class="blog-left--menu d-flex flex-wrap">
                        <?php foreach ($categories as $category):?>
                            <?php if(isset($category_alias) && $category->alias == $category_alias):?>
                                <div class="blog-left-menu__item active">
                                    <span><i class="icon-other icon-candy"></i></span>
                                    <span><?= $category->title?></span>
                                </div>
                            <?php else:?>
                                <div class="blog-left-menu__item">
                                    <span><i class="icon-other icon-candy"></i></span>
                                    <a href="<?= Url::toRoute(['/blog/category/'.$category->alias])?>"><?= $category->title?></a>
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                    <?php endif;?>

                    <div class="blog-left--fields">
                        <?php if ($countries) : ?>
                            <div class="filter-items__item filter-items__item_country">
                                <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0" >
                                    <select class="mobile-shadow-select d-md-none"
                                            name="shadowSelectCountry"
                                            data-tags="true"
                                            data-container-css-class="redirect-action-1"
                                    >
                                        <option value="">Страна</option>
                                        <?php foreach ($countries as $k => $v): ?>
                                            <option value="<?php echo $v['alias']; ?>"
                                                    class="redirect-action" <?= isset($checkCountry) && $checkCountry == $v['name']?'selected':''?>
                                                    data-action="country"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="js-states form-control country-select search-select blog-selects"
                                            name="filterCountry"
                                            id="filterCountryInput"
                                            data-tags="true"
                                            data-container-css-class="redirect-action-1"
                                            value="<?= isset($country_id)?$countries[$country_id]['alias']: 'Страны'?>"
                                            data-action="country"
                                    >
                                        <option value=""></option>
                                        <?php foreach ($countries as $k => $v): ?>
                                            <option value="<?php echo $v['alias']; ?>"
                                                    class="redirect-action" <?= isset($checkCountry) && $checkCountry == $v['name']?'selected':''?>
                                                    data-action="country"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($hotels) : ?>
                            <div class="filter-items__item filter-items__item_country">
                                <div class="filter-items__header d-flex justify-content-between align-items-stretch p-0" >
                                    <select class="mobile-shadow-select d-md-none"
                                            name="shadowSelectHotels"
                                            data-tags="true"
                                            data-container-css-class="redirect-action-1"
                                            data-action="hotel"
                                    >
                                        <option value="">Выберите отель</option>
                                        <?php foreach ($hotels as $k => $v): ?>
                                            <option value="<?php echo $v['alias']; ?>"
                                                    class="redirect-action" <?= isset($checkHotel) && $checkHotel == $v['name']?'selected':''?>
                                                    data-action="hotel"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select class="js-states form-control hotelReview-select country-select search-select blog-selects"
                                            name="filterCountry"
                                            id="filterCountryInput1"
                                            data-tags="true"
                                            data-container-css-class="redirect-action-1"
                                            value="<?= isset($hotel_id)?$hotels[$hotel_id]['name']: ''?>"
                                            data-action="hotel"
                                    >
                                        <option value=""></option>
                                        <?php foreach ($hotels as $k => $v): ?>
                                            <option value="<?php echo $v['alias']; ?>"
                                                    class="redirect-action" <?= isset($checkHotel) && $checkHotel == $v['name']?'selected':''?>
                                                    data-action="hotel"><?php echo $v['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if($tags):?>
                    <div class="blog-left--tags">
                        <h2 class="tags-title">Тэги:</h2>
                        <div class="tags-row">
                            <?php foreach ($tags as $tag):?>
                                <?php if(isset($tag_alias) && $tag->alias == $tag_alias):?>
                                    <span class="tag-row--item activated"><?= $tag->title?></span>
                                <?php else:?>
                                    <a href="<?= Url::toRoute(['/blog/tag/'.$tag->alias])?>" class="tag-row--item"><?= $tag->title?></a>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <?php endif;?>
                </aside>
                <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9 blog-right">


<!--  Posts  -->
<?php if($posts):?>
    <h2 class="blog-right--title">Новости</h2>
    <div class="swiper-container swiper-blog-container pt-3">
        <div class="swiper-wrapper swiper-blog--container_wrapper">
        <?php foreach ($posts as $id => $post):?>
            <div id="post_<?=$id?>" class="swiper-slide card-blog-bottom margin-b-30">
                <div class="card card-size-s card-blog">
                    <div class="card-header">
                        <div class="card-header--image preloader-inner">
                            <img src="<?= ImageHelper::frontendImg($post) ?>"
                                 alt="<?= ImageHelper::getAltFront($post) ?>">
                            <div class="card-header--common">
                                <div class="card-blog--title text-white font-montserrat font-size-s">
                                    <p><?= $post->title?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body--region d-flex">
                            <span class="blog-date"><?= DateHelper::dateFrontend($post->published_at)?></span>
                            <span class="blog-views">
                                <i class="icon-other icon-eye"></i><?= $post->views?>
                            </span>
                        </div>
                        <h6 class="card-body--desc desc-fade"><?= $post->description?></h6>
                    </div>
                    <div class="card-footer">
                        <?php $action = isset($post->hotel_id)? '/blog/hotel-review/' :'/blog/post/'?>
                        <?= Html::a('Подробнее',Url::toRoute([$action . $post->alias]),['class' => 'no-btn'])?>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        </div>
        <div class="visible-1199">
            <div class="swiper-pagination swiper-bottom-blog-pagination w-100"></div>
        </div>
    </div>
    <?php if(count($posts) < $all_posts_count):?>
        <div class="row">
            <div class="col-md-12">
                <?= Html::button('показать еще',[
                    'class' => 'btn-white show-more-post',
                    'data-route' => $route
                ])?>
            </div>
        </div>
    <?php endif;?>
<?php endif;?>
                </div>
            </div>
        </div>
    </div>
</section>
