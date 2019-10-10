<?php

/* @var $user common\models\User*/
/* @var $hotel_id*/
/* @var $hotel_review_id*/

use yii\helpers\Url;

?>

<div class="modal fade"
     id="modal-drop-comment"
     tabindex="-1"
     role="dialog"
     aria-hidden="true"
>
    <div class="modal-dialog" role="dialog">
        <div class="modal-content modal-action-notification">
                <div class="modal-header modal-header-center d-flex justify-content-center">
                    <h2 class="modal-title">оставить отзыв</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times</button>
                </div>
            <input type="hidden" name="review-user-id" value="<?=$user->id?>">
            <input type="hidden" name="hotel-id" value="<?=$hotel_id->hotel_id??null?>">
            <input type="hidden" name="review-hotel-id" value="<?=$hotel_review_id;?>">
                <div class="modal-body ordered">
                    <div class="modal-body--rating text-center">
                        <div class="star-rating with-hover text-center">
                            <fieldset class="rate">
                                <input id="rate1-star5" type="radio" name="rate1" value="5"/>
                                <label class="icon icon-star" for="rate1-star5" title="Excellent"></label>

                                <input id="rate1-star4" type="radio" name="rate1" value="4"/>
                                <label class="icon icon-star" for="rate1-star4" title="Good"></label>

                                <input id="rate1-star3" type="radio" name="rate1" value="3"/>
                                <label class="icon icon-star" for="rate1-star3" title="Satisfactory"></label>

                                <input id="rate1-star2" type="radio" name="rate1" value="2"/>
                                <label class="icon icon-star" for="rate1-star2" title="Bad"></label>

                                <input id="rate1-star1" type="radio" name="rate1" value="1"/>
                                <label class="icon icon-star" for="rate1-star1" title="Very bad"></label>
                            </fieldset>
                        </div>
                        <span class="font-size-xs color-979797 rate-for-review">Выберите оценку для отеля</span>
                    </div>
                    <div class="modal-body--fields d-flex flex-wrap">
                        <div class="form-group">
                            <input type="text" name="review-title" placeholder="Заголовок для Вашего отзыва">
                        </div>
                        <div class="form-group">
                            <input type="text" name="" value="<?= $user->getFullName()?>" placeholder="*Ваше имя">
                        </div>
                        <div class="form-group">
                            <input type="email" name="" value="<?= $user->email?>" placeholder="*Ваш e-mail">
                        </div>
                        <div class="form-group label-decorated">
                            <input type="file" name="review-avatar" data-avatar="" multiple="multiple" accept="image/*" style="display: none" id="photo-file">
                            <label for="photo-file">
                                <img src="../../img/addfile.png" alt="" width="22" class="mr-2">
                                <span class="attach-avatar">Прикрепите Ваше фото</span>
                            </label>
                        </div>
                        <div class="form-group mw-100">
                            <textarea name="review-comment" placeholder="Ваш отзыв"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn-regular send-review">
                        отправить
                    </button>
                </div>
        </div>
    </div>
</div>