<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use backend\modules\filemanager\widgets\FileInput;

/* @var $model backend\modules\user\forms\PassportForm */
?>
<fieldset>
    <legend>Паспортный данные</legend>
    <?php $form = ActiveForm::begin([
        'id' => 'form-passport',
        'action' => ['/cabinet/settings/edit-passport']
    ]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'first_name')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'last_name')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'patronymic')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'birthday')->widget(DatePicker::className(),[
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy'
                ]
            ])->label('День рождения') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'series')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'number')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'issued_date')->widget(DatePicker::className(),[
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd/mm/yyyy'
                ]
            ]) ?>
        </div>
    </div>
    <?= $form->field($model, 'issued')->textarea(['row' => 2]) ?>

    <?php if(isVerifyPassport()):?>
        <?= $form->field($model, 'media_id')->widget(FileInput::className(), [
            'buttonTag' => 'button',
            'buttonName' => 'Выбрать',
            'buttonOptions' => ['class' => 'btn btn-default'],
            'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
            'thumb' => 'original',
            'imageContainer' => '.img',
            'frameSrc' => '/admin/filemanager/file/filemanager',
            'pasteData' => FileInput::DATA_ID
        ])->label('Загрузить скан паспорта'); ?>
    <?php endif;?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'passport-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</fieldset>
