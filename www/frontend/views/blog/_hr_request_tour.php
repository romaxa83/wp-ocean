<?php

use backend\modules\request\models\Request;
use himiklab\yii2\recaptcha\ReCaptcha3;
use yii\helpers\Url;
?>
<div class="container">
    <div class="row">
        <div class="offset-lg-1 col-12 col-lg-11">
            <h2 class="block-header">
                Оставить заявку на подбор тура в этот отель
            </h2>
        </div>
    </div>
    <form action="<?php echo Url::to('/tour/save-request', TRUE); ?>"
          method="post"
          id="form-save-request-page">
        <div class="row align-items-stretch">
            <div class="offset-lg-1 col-12 col-lg-10">
                <div class="d-flex flex-wrap w-100">
                    <div class="modal-body--fields fields-left">
                        <input type="hidden" name="type" value="<?= Request::TYPE_REQUEST ?>">
                        <div class="form-group required-input">
                            <input type="text" name="name" placeholder="Ваше имя">
                        </div>
                        <div class="form-group required-input">
                            <input type="tel" name="phone" placeholder="Ваш телефон">
                        </div>
                        <div class="form-group required-input">
                            <input type="email" name="email" placeholder="Ваш e-mail">
                        </div>
                        <div class="recaptcha m-auto">
                            <?php echo ReCaptcha3::widget([
                                'name' => 'reCaptcha',
                                'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                                'action' => 'request'
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
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button"
                                class="save-request-page btn-find btn-regular btn-size-m button-isi" data-badge="inline">
                            Отправить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
