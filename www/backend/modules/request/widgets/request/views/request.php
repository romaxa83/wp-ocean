<?php

use yii\helpers\Url;
use himiklab\yii2\recaptcha\ReCaptcha3;
?>
<section class="section find-tour-form grey-bg" id="form-for-application">
    <div class="container">
        <div class="section-header header-text-right w-b-150 active line-bottom" id="line-2">
            <div class="row">
                <div class="offset-md-3 offset-lg-3 col-12 col-md-8 col-lg-7 header-title active pl-5" id="animate2">
                    <span class="header-title__text">отправьте заявку</span>
                    <h2 class="header-title__title pl-0">на подбор тура</h2>
                </div>
            </div>
        </div>
        <form action="<?php echo Url::to('/tour/save-request', TRUE); ?>" method="POST" id="form-save-request-page">
            <div class="row align-items-stretch">
                <div class="offset-lg-1 col-12 col-lg-10">
                    <div class="row inputs-wrapper">
                        <div class="col-12 col-lg-6 form-left">
                            <input type="hidden" name="type" value="0">
                            <div class="tour-form-input required-input modal-body--fields">
                                <input type="text" placeholder="Ваше имя" name="name">
                            </div>
                            <div class="tour-form-input required-input modal-body--fields">
                                <input type="tel" placeholder="Ваш телефон" name="phone" maxlength="17">
                            </div>
                            <div class="tour-form-input required-input modal-body--fields">
                                <input type="email" placeholder="Ваш e-mail" name="email">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 form-right pl-lg-0">
                            <div class="tour-form-input mb-0 modal-body--fields h-166px">
                                <textarea placeholder="Сообщение" name="comment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="recaptcha">
                                <?php
                                echo ReCaptcha3::widget([
                                    'name' => 'reCaptcha',
                                    'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                    'action' => 'request'
                                ]);
                                ?>
                            </div>
                            <button type="button" class="save-request-page btn-find btn-regular btn-size-m button-isi" data-badge="inline">
                                Отправить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>