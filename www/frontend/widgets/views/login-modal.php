<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model \common\models\LoginForm */
?>
<div class="modal fade pl-3 pr-3" id="modal-login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-wide-small" role="dialog">
        <div class="modal-content modal-action-notification">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => [ 'site/login' ],
                'enableAjaxValidation' => true,
                'validationUrl' => Url::toRoute('site/validate-ajax-login')
            ]); ?>
                <div class="modal-header modal-header-center d-flex justify-content-center">
                    <h2 class="modal-title font-size-md">вход в личный кабинет</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body modal-body--fields mb-4">
                    <div class="modal-social--group mb-4">
                        <p class="text-center color-909090 font-weight-500 font-size-s mb-2">Войти с помощью:</p>
                        <div class="d-flex justify-content-center">
                            <a href="<?= Yii::$app->params['google']?>" class="modal-social--group__item facebook-hover ml-2 mr-2">
                                <img src="/img/icons/google-v2.svg" width="22" height="22" alt="image format png"/>
                            </a>
                            <a href="<?= Yii::$app->params['facebook']?>" class="modal-social--group__item facebook-hover ml-2 mr-2">
                                <img src="/img/icons/facebook-v2.svg" width="22" height="22" alt="image format png"/>
                            </a>
                        </div>
                    </div>
                    <?= $form->field($model, 'email')->textInput([
                        'placeholder' => '*Ваш e-mail',
                        'type' => 'email'
                    ])->label(false) ?>

                    <?= $form->field($model, 'password')->textInput([
                        'placeholder' => '*Ваш пароль',
                        'type' => 'password'
                    ])->label(false) ?>
                </div>
                <div class="modal-footer flex-column">
                    <?= Html::submitButton('Войти', [
                        'class' => 'btn-regular btn-size-m button-isi w-100 mw-100 mb-4',
                        'name' => 'login-button'
                    ]) ?>
                    <a href="#" class="signup-link text-center color-orange font-weight-700 font-size-s mb-2">
                        Ещё не зарегистрированы?
                    </a>
                    <a href="#"
                       data-toggle="modal"
                       data-target="#modal-password-reset-request"
                       class="password-reset-request text-center grey-to-black font-weight-500 font-size-s">
                        Забыли пароль?
                    </a>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>