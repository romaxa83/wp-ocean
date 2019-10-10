<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model \frontend\models\PasswordResetRequestForm */
?>
<div class="modal fade" id="modal-password-reset-request" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-wide-small" role="dialog">
        <div class="modal-content modal-action-notification">
            <?php $form = ActiveForm::begin([
                'id' => 'request-password-reset-form',
                'action' => [ 'site/request-password-reset' ],
                'enableAjaxValidation' => true,
                'validationUrl' => Url::toRoute('site/validate-ajax-request-password-reset')
            ]); ?>
            <div class="modal-header modal-header-center d-flex justify-content-center">
                <h2 class="modal-title font-size-md">Зброс пароля</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <p class="text-center color-909090 font-weight-500 font-size-s mb-3">Введите почту на которую был зарегистрирован аккаунт.</p>
            <p class="text-center color-909090 font-weight-500 font-size-s mb-3">После отправки перейдите на указаную почту.</p>
            <div class="modal-body modal-body--fields">
                <?= $form->field($model, 'email')->textInput([
                    'placeholder' => '*Ваш e-mail',
                    'type' => 'email'
                ])->label(false) ?>
            </div>
            <div class="modal-footer flex-column">
                <?= Html::submitButton('Отправить', [
                    'class' => 'btn-regular btn-size-m button-isi w-100 mw-100',
                    'name' => 'login-button'
                ]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>