<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $h1 */
/** @var string $description_part_1 */
/** @var string $description_part_2 */
/** @var string $subtitle_1 */
/** @var string $subtitle_2 */
/** @var string $subtitle_3 */
/** @var string $subtitle_4 */
/** @var string $block_1 */
/** @var string $block_2 */
/** @var string $block_3 */
/** @var string $block_4 */
/** @var string $experience */
/** @var array $sectionTitle */
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
    <div class="section">
        <div class="container">
            <div class="section-header header-text-left v2 w-265percent-before" id="line-1">
                <div class="row">
                    <div class="col-9 offset-md-0 offset-lg-2 header-title" id="animate1">
                        <h1 class="header-title__title"><span
                                    class="header-title__text text-lg-right"><?= $h1['row_1'] ?></span><?= $h1['row_2'] ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="vacancy-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                        <?= Html::decode($description_part_1) ?>
                    </div>
                    <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                        <?= Html::decode($description_part_2) ?>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                                <h3 class="list-title"><?= Html::decode($subtitle_1) ?></h3>
                                <?= Html::decode($block_1) ?>
                            </div>
                            <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                                <h3 class="list-title"><?= Html::decode($subtitle_2) ?></h3>
                                <?= Html::decode($block_2) ?>
                            </div>
                            <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                                <h3 class="list-title"><?= Html::decode($subtitle_3) ?></h3>
                                <?= Html::decode($block_3) ?>
                            </div>
                            <div class="col-12 col-lg-6 text-content seo-wrapper-v2">
                                <h3 class="list-title"><?= Html::decode($subtitle_4) ?></h3>
                                <?= Html::decode($block_4) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center action-content">
                        <button type="button" data-toggle="modal" data-target="#modal-join-us"
                                class="btn-regular button-isi btn-size-m">откликнуться
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php if(! empty($vacancies)) : ?>
<div class="head-wrap v2 blue to-left section">
    <div class="section-header header-text-left" id="line-2">
        <div class="container">
            <div class="row">
                <div class="col-12 header-title" id="animate2">
                    <div class="title-wrap">
                        <h2 class="header-title__title"> <span class="header-title__text"><?= $sectionTitle['row_1'] ?></span><?= $sectionTitle['row_2'] ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="single_vacancy2" class="slider-content vacancy v2 single">
    <div class="container">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($vacancies as $vacancy) : ?>
                    <div class="swiper-slide">
                        <div class="slide-wrap">
                            <div class="item-content">
                                <h3 class="content-title"><?= $vacancy['title'] ?></h3>
                                <div class="content-text mb-3">
                                    <div class="text-wrap-line-4">
                                        <?= Html::decode($vacancy['channelRecordContent']['description_part_1']['content']) ?>
                                    </div>
                                    <div>
                                        <b>Опыт работы:</b> <?= $vacancy['channelRecordContent']['experience']['content'] ?>
                                    </div>
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