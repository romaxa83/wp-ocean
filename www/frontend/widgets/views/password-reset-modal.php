<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model \frontend\models\ResetPasswordForm */
/* @var $token */
?>
<div class="modal fade" id="modal-reset-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-wide-small" role="dialog">
        <div class="modal-content modal-action-notification">
            <?php $form = ActiveForm::begin([
                'id' => 'password-reset-form',
                'action' => Url::to(['site/reset-password','token' => $token]),
            ]); ?>
            <div class="modal-header modal-header-center d-flex justify-content-center">
                <h2 class="modal-title font-size-md">Введите новый пароль</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body modal-body--fields">
                <?= $form->field($model, 'password')->textInput([
                    'placeholder' => '*Пароль',
                    'type' => 'password'
                ])->label(false) ?>

                <?= $form->field($model, 'password_confirm')->textInput([
                    'placeholder' => '*Повторите пароль',
                    'type' => 'password'
                ])->label(false) ?>
            </div>
            <div class="modal-footer flex-column">
                <?= Html::submitButton('Отправить', [
                    'class' => 'btn-regular btn-size-m button-isi w-100 mw-100',
                ]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>