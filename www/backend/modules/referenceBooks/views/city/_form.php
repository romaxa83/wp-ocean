<?php

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;

$this->title = 'Добавление города';

$this->params['breadcrumbs'][] = ['label' => 'Справочник городов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referenceBooks-country-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'country-form', 'method' => 'POST']); ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Общая информация</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Данные для карты</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <?php echo $form->field($city, 'cid')->hiddenInput()->label(FALSE); ?>
                                <?php
                                echo $form->field($city, 'country_id')->widget(Select2::classname(), [
                                    'data' => $country,
                                    'options' => ['placeholder' => 'Выбрать страну ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <?php echo $form->field($city, 'code'); ?>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <?php echo $form->field($city, 'name'); ?>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div style="display: flex;">
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($city->getAttributeLabel('capital'), 'capital', ['class' => 'tgl-btn']) . Html::checkbox('City[capital]', $city->capital, [
                                            'id' => 'capital',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($city->capital) ? $city->capital : 0,
                                        ]) . Html::label('', 'capital', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($city->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('City[status]', $city->status, [
                                            'id' => 'status',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($city->status) ? $city->status : 0,
                                        ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($city->getAttributeLabel('sync'), 'sync', ['class' => 'tgl-btn']) . Html::checkbox('City[sync]', $city->sync, [
                                            'id' => 'sync',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($city->sync) ? $city->sync : 0,
                                        ]) . Html::label('', 'sync', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo $form->field($city, 'description')->widget(TinyMce::className(), [
                            'options' => ['rows' => 6, 'class' => 'field-tiny-mce'],
                            'language' => 'ru',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <?php echo $form->field($city, 'lat')->textInput(['type' => 'number']); ?>
                        <?php echo $form->field($city, 'lng')->textInput(['type' => 'number']); ?>
                        <?php echo $form->field($city, 'zoom')->textInput(['type' => 'number']); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="<?php echo Url::to(['/referenceBooks/city']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <?php echo Html::resetButton('Сбросить', ['class' => 'btn btn-primary']) ?>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>