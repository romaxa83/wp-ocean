<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model common\models\SignUpForm */
?>
<div class="row">
    <div class="col-lg-5">

        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute('site/validate-ajax-signup')
        ]); ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model->passport, 'first_name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model->passport, 'last_name') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'phone')->widget( yii\widgets\MaskedInput::class, [
            'name' => 'phone',
            'mask' => '+38(999)-999-9999'
        ]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_confirm')->passwordInput() ?>

        <?= $form->field($model, 'confidentiality')->checkbox()
            ->label('Я прочитал и принял <a href="#">Условия и Политику конфиденциальности</a>') ?>

        <div class="form-group">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            <?= Html::a('Войти', ['site/login'],['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>