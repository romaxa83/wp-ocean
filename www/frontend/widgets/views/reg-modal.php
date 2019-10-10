<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model common\models\SignUpForm */
?>
<div class="modal fade pl-3 pr-3" id="modal-registration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-wide-small" role="dialog">
        <div class="modal-content modal-action-notification">
            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'action' => [ 'site/signup' ],
                'enableAjaxValidation' => true,
                'validationUrl' => Url::toRoute('site/validate-ajax-signup')
            ]); ?>
                <div class="modal-header modal-header-center d-flex justify-content-center">
                    <h2 class="modal-title font-size-md">регистрация</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body modal-body--fields mb-4">
                    <div class="modal-social--group mb-4">
                        <p class="text-center color-909090 font-weight-500 font-size-s mb-2">Быстрая регистрация с помощью:</p>
                        <div class="d-flex justify-content-center">
                            <a href="<?= Yii::$app->params['google']?>" class="modal-social--group__item facebook-hover ml-2 mr-2">
                                <img src="/img/icons/google-v2.svg" width="22" height="22" alt="image format png"/>
                            </a>
                            <a href="<?= Yii::$app->params['facebook']?>" class="modal-social--group__item facebook-hover ml-2 mr-2">
                                <img src="/img/icons/facebook-v2.svg" width="22" height="22" alt="image format png"/>
                            </a>
                        </div>
                    </div>
                    <?= $form->field($model->passport, 'first_name')->textInput([
                        'placeholder' => '*Ваше имя',
                    ])->label(false) ?>

                    <?= $form->field($model->passport, 'last_name')->textInput([
                        'placeholder' => '*Ваша фамилия'
                    ])->label(false) ?>

                    <?= $form->field($model, 'email')->textInput([
                        'placeholder' => '*Ваш e-mail',
                        'type' => 'email'
                    ])->label(false) ?>

                    <?= $form->field($model, 'phone')->widget( yii\widgets\MaskedInput::class, [
                        'name' => 'phone',
                        'mask' => '+38(999)-999-9999'
                    ])->textInput( [ 'placeholder' => '*Ваш телефон' ] )->label( false ) ?>

                    <?= $form->field($model, 'password')->textInput([
                        'placeholder' => '*Пароль',
                        'type' => 'password'
                    ])->label(false) ?>

                    <?= $form->field($model, 'password_confirm')->textInput([
                        'placeholder' => '*Повторите пароль',
                        'type' => 'password'
                    ])->label(false) ?>

                    <?= $form->field( $model, 'confidentiality', [
                        'template' => '<div class="checkbox filter-checkboxes confirm-checkbox p-0 mt-4 mb-4">{input} 
                         <label class="confirm-confidencial pl-5" for="signupform-confidentiality">Я принимаю условия и политику конфиденциальности</label>{error}</div>',

                    ] )->textInput( [
                        'type' => 'checkbox',
                        'class' => 'custom-control-input'
                    ] ) ?>

                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('создать аккаунт', [
                        'class' => 'req-btn-on-modal btn-regular btn-size-m button-isi w-100 mw-100',
                        'name' => 'signup-button'
                    ]) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>