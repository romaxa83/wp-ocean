<?php
use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\helpers\ImageHelper;
use yii\helpers\Url;

/** @var $hotelReview */
/** @var $reviewHelper backend\modules\blog\helpers\ReviewsHelper*/
?>

<section class="section section-reviews">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="block-header">
                    Отзывы об отеле (<span>
                            <?= isset($hotelReview->hotel->reviews)
                                ?$hotelReview->hotel->getReviews()->where(['status' => 1])->count()
                                :0?>
                        </span>)
                </h2>
            </div>
        </div>
        <div class="hotel-rating">
            <p class="hotel-rating__title">Оценка путешественников</p>
            <?php foreach(isset($hotelReview->hotel->reviews)
                              ? $reviewHelper->getDataReviews($hotelReview->hotel->getReviews()->where(['status' => 1])->all())
                              : $reviewHelper->getDataNotReviews() as $item):?>
                <div class="hotel-rating__item">
                    <div class="checkbox">
                        <input type="checkbox" name="rating[]" class="filter-review" data-type="<?=$item['type']?>" id="Stars_<?=$item['type']?>">
                        <label for="Stars_<?=$item['type']?>"><?=$item['name']?></label>
                    </div>
                    <div class="hotel-rating__progress-bar">
                        <div class="progressbar-wrapper">
                            <div class="progressbar" style="width: <?=$item['percent']?>%"></div>
                        </div>
                        <div class="review-counter">(<span><?=$item['count']?></span>)</div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>


    <div class="container reviews-wrapper">
        <?php if($hotelReview->hotel->reviews):?>
            <div class="row row-tour-testimonials">
                <?php $render = 0?>
                <?php foreach ($hotelReview->hotel->getReviews()->where(['status' => 1])->all() as $review):?>
                    <div class="reviewShowHotel tour-testimonials row w-100 p-0 <?php echo ($render >= Yii::$app->params['review__on_page']) ? 'd-none' : FALSE; ?>"
                         data-type-reviews="<?= $reviewHelper->getRatingForFiveSystem($review->vote)?>">
                        <div class="tour-testimonials--avatar col-12 col-sm-3 col-md-2 m-0 text-center">
                            <img src="<?= $review->avatar?>"
                                 alt="<?= ImageHelper::getAltReviewAvatar($review->avatar)?>"
                                 width="71">
                            <h6 class="tour-testimonials--name font-size-xs">
                                <?= $review->user_id !== null
                                    ? $review->author->getFullName()
                                    : $review->user?>
                            </h6>
                        </div>
                        <div class="tour-testimonials--desc col-12 col-sm-9 col-md-10">
                            <div class="testimonials-desc--top d-flex align-items-baseline">
                                <div class="star-rating d-flex font-size-xs mr-4">
                                    <?php $count = $reviewHelper->getRatingForFiveSystem($review->vote) ?>
                                    <?php for ($i = 1;$i < 6;$i++):?>
                                        <?php if($count > 0):?>
                                            <span><i class="icon icon-star active"></i></span>
                                        <?php else:?>
                                            <span><i class="icon icon-star "></i></span>
                                        <?php endif;?>
                                        <?php $count--?>
                                    <?php endfor;?>
                                </div>
                                <div class="testimonials--date color-6e6e6e font-size-xs font-weight-normal">
                                    <span><?= DateHelper::convertDateTimeFormat($review->date)?></span>
                                </div>
                            </div>
                            <div class="testimonials-desc--middle">
                                <h2><?= $review->title?></h2>
                                <p class="font-size-xs color-979797 truncate-v2"><?= $review->comment?></p>
                            </div>
                            <!-- Дата посещения (в разработке) -->
                            <?php if(false):?>
                                <div class="testimonials-desc--bottom">
                                    <h6 class="font-size-xs">
                                        <span class="font-weight-400 color-6e6e6e">Дата посещения:</span>
                                        <span class="font-weight-500">Декабрь</span>
                                    </h6>
                                </div>
                            <?php endif;?>
                        </div>
                        <!-- Ответ на отзыв (в разработке) -->
                        <?php if(false):?>
                            <div class="answers-wrapper col-12 d-flex flex-wrap p-0">
                                <div class="answer offset-3 col-9">
                                    <h6 class="answer__header">Николай ответил на этот отзыв:</h6>
                                    <div class="testimonials--date color-6e6e6e font-size-xs font-weight-normal">
                                        <span>10.01.19</span>
                                    </div>
                                    <p class="font-size-xs color-979797">
                                        This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor
                                        aliquet. Aenean sollicitudin,
                                        lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id
                                        elit. Duis sed odio sit amet
                                        nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus
                                        a odio tincidunt auctor a
                                        ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. C
                                    </p>
                                </div>

                                <div class="answer offset-3 col-9">
                                    <h6 class="answer__header">Николай ответил на этот отзыв:</h6>
                                    <div class="testimonials--date color-6e6e6e font-size-xs font-weight-normal">
                                        <span>10.01.19</span>
                                    </div>
                                    <p class="font-size-xs color-979797">
                                        This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor
                                        aliquet. Aenean sollicitudin,
                                        lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id
                                        elit. Duis sed odio sit amet
                                        nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus
                                        a odio tincidunt auctor a
                                        ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. C
                                    </p>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                    <?php $render++;?>
                <?php endforeach;?>

                <!-- </div> -->
            </div>
            <div class="testimonials-btns d-flex flex-wrap justify-content-center">
                <div class="text-center d-flex">
                    <?php if($hotelReview->hotel->getReviews()->where(['status' => 1])->count() > Yii::$app->params['review__on_page']):?>
                        <button data-review-on-page="<?= Yii::$app->params['review__on_page']?>" class="more-review btn-white btn-size-m">Показать еще</button>
                    <?php endif;?>
                </div>
            </div>
        <?php endif;?>
        <?php if(false):?>
            <?php if(Yii::$app->user->identity):?>
                <div class="text-center">
                    <a href="#"
                       data-toggle="modal" data-target="#modal-drop-comment"
                       class="btn-find btn-regular btn-size-m button-isi">Оставить отзывы</a>
                </div>
            <?php else:?>
                <div class="testimonials-btns d-flex flex-wrap justify-content-center">
                    <div class="text-center d-flex">
                        <a href="<?= Url::toRoute(['site/login'])?>"
                           class="btn-find btn-regular btn-size-m button-isi">Оставить отзывы</a>
                        <?php if($hotelReview->hotel->getReviews()->where(['status' => 1])->count() > Yii::$app->params['review__on_page']):?>
                            <button data-review-on-page="<?= Yii::$app->params['review__on_page']?>" class="more-review btn-white btn-size-m">Показать еще</button>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
        <?php endif;?>
    </div>
</section>
