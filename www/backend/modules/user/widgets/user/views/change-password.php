<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model backend\modules\user\forms\PasswordForm */
?>

<fieldset>
    <legend>Смена пароля</legend>
    <div class="row">
        <?php $form = ActiveForm::begin([
            'id' => 'form-change-password',
            'action' => ['/cabinet/settings/change-password','id' => $model->userId],
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute('/cabinet/settings/validate-ajax-change-password')
        ]); ?>
        <div class="col-md-3">
            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Пароль',
            ])->label('') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'password_new')->passwordInput([
                'placeholder' => 'Новый пароль',
            ])->label('') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'password_confirm')->passwordInput([
                'placeholder' => 'Потверждения пароль',
            ])->label('') ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</fieldset>


