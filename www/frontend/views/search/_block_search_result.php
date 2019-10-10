<?php

use yii\helpers\Url;
use backend\modules\request\widgets\request\RequestWidget;

$hs = Yii::$app->params['hotel_service'];
$get = Yii::$app->request->get();
$this->title = 'Результаты поиска';
?>


<?php if (isset($hotel_list) && count($hotel_list)): ?>
    <div class="search-results">
        <div class="container">
            <div class="results-parametrs d-none d-lg-flex">
                <div class="btn-parametr btn-cube" data-view="0">
                    <i class="icon-other icon-cubes
                    <?php echo (!Yii::$app->session->has('search_view')) ? 'active' : '' ?>
                       <?php echo (Yii::$app->session->has('search_view') && Yii::$app->session->get('search_view') == 0) ? 'active' : '' ?>"></i>
                </div>
                <div class="btn-parametr btn-list" data-view="1">
                    <i class="icon-other icon-list <?php echo (Yii::$app->session->has('search_view') && Yii::$app->session->get('search_view') == 1) ? 'active' : '' ?>"></i>
                </div>
            </div>
            <div class="result-cards-wrapper row sales-container <?php echo (Yii::$app->session->has('search_view') && Yii::$app->session->get('search_view') == 1) ? 'list-style' : '' ?>">
                <?php
                echo $this->render('_block_hotels', [
                    'hotels' => $hotels,
                    'data_api' => $data_api,
                    'hotel_list' => $hotel_list,
                    'hotels_info' => $hotels_info,
                    'hotel_review' => $hotel_review
                ]);
                ?>
                <div class="result-card col-xs-12 col-md-6 col-xl-4 btn-card-more">
                    <div class="card card-size-s ">
                        <div class="card-more-wrapper submit-filter" data-page="2">
                            <div class="more-loader"></div>
                            <div class="more-text">
                                Показать еще
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="search-results">
        <div class="container">
            <div class="row">
                <div class="col-12 not-found">
                    <div class="text-center">
                        <img alt="bag-trip" src="/frontend/web/img/not-found.png">
                    </div>
                    <p class="msg text-center ml-auto mr-auto">К сожалению, на данный момент предложений <br> по данному
                        направлению нет.</p>
                    <p class="msg text-center ml-auto mr-auto">
                        Наши travel-эксперты могут подобрать для вас
                        индивидуальный тур учитывая все ваши пожелания. Для этого жмите «Оставить заявку» или смотрите
                        другие предложения
                    </p>
                    <div class="d-flex flex-wrap justify-content-center">
                        <button class="btn-regular button-isi btn-shadow btn-size-m ml-2 mr-2 btn-to-form">оставить заявку</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($disabled_hotel) && count($disabled_hotel) > 0): ?>
        <section class="section">
            <div class="container">
                <div class="row row-cards">
                    <?php foreach ($disabled_hotel as $k => $v): ?>
                        <?php $img = @getimagesize(Url::to('/admin/' . $v['media']['url'], TRUE)); ?>
                        <div class="col-xs-12 col-md-6 col-xl-4">
                            <div class="card card-size-s card-disabled">
                                <div class="card-header">
                                    <div class="card-header--image preloader-inner">
                                        <?php if ($img): ?>
                                            <img src="<?php echo Url::to('/admin/' . $v['media']['url'], TRUE); ?>" alt="<?php echo $v['media']['alt']; ?>"/>
                                        <?php else : ?>
                                            <img src="<?php echo Url::to('/admin/img/logo_no_photo.png', TRUE); ?>" alt="" class="img-not-found"/>
                                        <?php endif; ?>
                                        <div class="card-header--common">
                                            <?php if (isset($disabled_hotel_review[$v['id']]['avg'])): ?>
                                                <div class="card--rating text-white font-montserrat font-size-s">
                                                    <span><strong><?php echo $disabled_hotel_review[$v['id']]['avg']; ?></strong> оценка</span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (isset($disabled_hotel_review[$v['id']]['count'])): ?>
                                                <div class="card--rating card--rating__testimonials text-white font-montserrat font-size-s">
                                                    <span><strong><?php echo $disabled_hotel_review[$v['id']]['count']; ?></strong> </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body--region d-flex">
                                        <span class="text-uppercase"><?php echo $v['name'] . ' ' . $v['category']['name']; ?></span>
                                    </div>
                                    <div class="card-body--hotel d-flex align-items-center">
                                        <h5><?php echo $v['countries']['name'] . ' ' . $v['cites']['name']; ?></h5>
                                    </div>
                                    <h6 class="card-body--desc desc-fade">
                                        <?php echo $v['address']['general_description']; ?>
                                    </h6>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="btn-regular btn-size-m button-isi">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>