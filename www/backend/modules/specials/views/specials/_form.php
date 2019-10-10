<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Добавление акции';

$this->params['breadcrumbs'][] = ['label' => 'Акции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specials-special-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'specials-form', 'method' => 'POST']); ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">
                            <?php echo $form->field($special, 'name'); ?>
                        </div>
                        <div class="col-md-3">
                            <div style="display: flex;">
                                <div class="box-custome-checkbox">
                                    <?php
                                    echo Html::label($special->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('Special[status]', $special->status, [
                                            'id' => 'status',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($special->status) ? $special->status : 0,
                                        ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($special, 'from_datetime', ['inputOptions' => [
                                'autocomplete' => 'off']])->widget(DateTimePicker::classname(), [
                                'options' => ['placeholder' => 'Выберите дату начала'],
                                'language' => 'ru',
                                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                                'layout' => '{picker}{input}{remove}',
                                'removeButton' => ['position' => 'append'],
                                'convertFormat' => false,
                                'pluginOptions' => [
                                    'todayBtn' => true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'timezone' => 'Europe/Kiev',
                                    'autoclose' => true,
                                    'weekStart' => 1
                                ]
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($special, 'to_datetime', ['inputOptions' => [
                                'autocomplete' => 'off']])->widget(DateTimePicker::classname(), [
                                'options' => ['placeholder' => 'Выберите дату окончания'],
                                'language' => 'ru',
                                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                                'layout' => '{picker}{input}{remove}',
                                'removeButton' => ['position' => 'append'],
                                'convertFormat' => false,
                                'pluginOptions' => [
                                    'todayBtn' => true,
                                    'format' => 'yyyy-mm-dd hh:ii:ss',
                                    'timezone' => 'Europe/Kiev',
                                    'autoclose' => true,
                                    'weekStart' => 1
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a href="<?php echo Url::to(['/specials/specials']) ?>" class="btn btn-primary">Вернуться к
                    списку</a>
                <?php echo Html::resetButton('Сбросить', ['class' => 'btn btn-primary']) ?>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>