<?php

use himiklab\yii2\recaptcha\ReCaptcha3;
use yii\helpers\Url;
?>

    <div class="modal-offer">
        <div class="modal fade" id="modal-application-tour" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="dialog">
                <div class="modal-content modal-action-notification">
                    <form action="<?php echo Url::to('/tour/save-order', TRUE); ?>"
                          method="post"
                          id="form-save-order">
                        <div class="modal-header modal-header-center d-flex justify-content-center">
                            <h2 class="modal-title">оставить заявку на тур</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body--tour_info">
                                <div class="tour_info--component">
                                    <div class="d-flex justify-content-sm-between mb-2">
                                        <h2 class="offerName font-size-18px font-weight-700"></h2>
                                        <div class="color-979797 hidden-sm">
                                            <span class="font-size-xs">За весь тур</span>
<!--                                            <span class="font-size-s"><del>--><?//= isset($data['price'])?\frontend\helpers\PriceHelper::viewUah($data['price']):false ?><!--</del></span>-->
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-sm-between">
                                        <h2 class="offerCountryCity font-size-s font-weight-400">></h2>
                                        <h4 class="offerPrice font-weight-800 font-size-md hidden-sm"></h4>
                                    </div>
                                </div>

                                <div class="tour_info--component tour-list d-flex flex-wrap justify-content-between">
                                    <div class="tour_info--component__item">
                                        <div class="tour-list--item before">
                                            <small>перелет</small>
                                            <div class="d-flex">
                                                Из&nbsp;<span class="offerDeptCity"></span>
                                            </div>
                                        </div>
                                        <div class="tour-list--item before">
                                            <small>дата вылета</small><span class="offerDateBegin"></span>
                                        </div>
                                    </div>
                                    <div class="tour_info--component__item">
                                        <div class="tour-list--item before">
                                            <small>проживание</small><span class="offerRoom"></span>
                                        </div>
                                        <div class="tour-list--item before">
                                            <small>питание</small><span class="offerFood"></span>
                                        </div>
                                    </div>
                                    <div class="tour_info--component__item">
                                        <div class="tour-list--item before">
                                            <small>ночей в туре</small>
                                            <div class="d-flex">
                                                <span class="offerDays"></span>
                                                <span>&#160;ночей</span>
                                            </div>
                                        </div>
                                        <div class="tour-list--item before">
                                            <small>туристы</small>
                                            <div class="d-flex">
                                                <span class="offerPeople"></span>
                                                <span>&#160;взр.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tour_info--component visible-xs">
                                    <div class="d-flex justify-content-between flex-wrap align-items-center">
                                        <span class="color-979797">За весь тур</span>
                                        <h2 class="offerPrice font-size-lg font-weight-800"></h2>
<!--                                        <span class="color-979797"><del>--><?//= isset($data['price'])?\frontend\helpers\PriceHelper::viewUah($data['price']):false ?><!--</del></span>-->
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-4 pt-4">
                                <span class="color-484848 font-weight-400 font-size-s">Остались вопросы? позвоните нам!</span>
                                <h5 class="font-weight-700"><?php echo Yii::$app->view->params['phone']; ?></h5>
                            </div>
                            <div class="d-flex flex-wrap w-100">
                                <div class="modal-body--fields fields-left">
                                    <input type="hidden" name="offer" readonly="readonly" value="">
                                    <input type="hidden" name="hotel_id" readonly="readonly" value="">
                                    <input type="hidden" name="price" readonly="readonly" value="">
                                    <input type="hidden" name="info" readonly="readonly" value="">
                                    <div class="form-group required-input">
                                        <input type="text" name="name" placeholder="Ваше имя">
                                    </div>
                                    <div class="form-group required-input">
                                        <input type="tel" name="phone" placeholder="Ваш телефон">
                                    </div>
                                    <div class="form-group required-input">
                                        <input type="email" name="email" placeholder="Ваш e-mail">
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        echo ReCaptcha3::widget([
                                            'name' => 'reCaptcha',
                                            'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                            'action' => 'order'
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                <div class="modal-body--fields fields-right">
                                    <div class="form-group">
                                        <textarea name="comment" placeholder="Сообщение"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button
                                        data-badge="inline"
                                        type="button"
                                        class="btn-regular button-isi w-240px save-order"
                                        data-offer
                                >оставить заявку</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


