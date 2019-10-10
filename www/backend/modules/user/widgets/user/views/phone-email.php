<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model backend\modules\user\forms\UserEditForm */
?>

<fieldset>
    <legend>Смена email и телефона</legend>
    <div class="row">
        <?php $form = ActiveForm::begin([
            'id' => 'form-change-email-phone',
            'action' => ['/cabinet/settings/change-email-phone'],
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute('/cabinet/settings/validate-ajax-edit-user')
        ]); ?>
        <div class="col-md-5">
            <?= $form->field($model, 'email')->textInput([
                'placeholder' => 'Email',
            ])->label('Email') ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'phone')->widget( yii\widgets\MaskedInput::class, [
                'name' => 'phone',
                'mask' => '+38(999)-999-9999'
            ])->label('Телефон') ?>
        </div>
        <div class="col-md-2">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</fieldset>