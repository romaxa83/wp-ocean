<?php
use kartik\date\DatePicker;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Паспортные данные(украинский)</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model->passport, 'patronymic')->textInput()->label('Отчество') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->passport, 'birthday')->widget(DatePicker::className(),[
                    'name' => 'birthday',
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd/mm/yyyy'
                    ]
                ])->label('Дата рождения') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model->passport, 'series')->textInput()->label('Серия') ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model->passport, 'number')->textInput()->label('Номер') ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model->passport, 'issued_date')->widget(DatePicker::className(),[
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd/mm/yyyy'
                    ]
                ])->label('Когда выдан') ?>
            </div>
        </div>

        <?= $form->field($model->passport, 'issued')->textarea(['row' => 2])->label('Кем выдан') ?>

    </div>
</div>