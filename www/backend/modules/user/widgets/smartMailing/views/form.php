<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;

/* @var $model backend\modules\user\forms\SmartMailingForm */
?>
<fieldset>
    <legend>Создать нову подписку</legend>
    <div class="row">
        <?php $form = ActiveForm::begin([
            'id' => 'form-smart-mailing',
            'action' => ['/cabinet/dispatch/create'],
        ]); ?>
        <div class="col-md-4">
            <?= $form->field($model, 'country_id')->widget(Select2::className(),[
                'name' => 'country_id',
                'data' => $model->getCountryList(),
                'language' => 'ru',
                'options' => [
                'id' => 'smartmailingform-country',
                'prompt' => 'Страна',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Страна') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'with')->widget(DateRangePicker::className(),[
                'model'=>$model,
                'language' => 'ru',
                'attribute'=>'datetime_range',
                'convertFormat'=>true,
                'startAttribute'=>'with',
                'endAttribute'=>'to',
                'pluginOptions'=>[
                    'timePicker'=>false,
                    'locale'=>[
                        'format'=>'d/m/Y'
                    ]
                ]
            ])->label('Дата(с-по)') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'persons')->textInput(['type' => 'number','min' => 1])->label('Кол-во человек') ?>
        </div>
        <div class="col-md-1">
            <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</fieldset>