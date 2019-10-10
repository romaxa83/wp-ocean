<?php

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\filemanager\widgets\FileInput;
use kartik\select2\Select2;

$this->title = 'Добавление развлечения';
$this->params['breadcrumbs'][] = ['label' => 'Справочник развлечений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referenceBooks-entertainment-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'entertainment-form', 'method' => 'POST']); ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php
                            echo $form->field($entertainment, 'country_id')->widget(Select2::classname(), [
                                'data' => $country,
                                'options' => ['placeholder' => 'Выбрать страну ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <?php
                            echo $form->field($entertainment, 'city_id')->widget(Select2::classname(), [
                                'data' => [],
                                'options' => ['placeholder' => 'Выбрать город ...', 'disabled' => 'disabled'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo $form->field($entertainment, 'name');
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <?php
                            echo $form->field($entertainment, 'media_id')->widget(FileInput::className(), [
                                'buttonTag' => 'button',
                                'buttonName' => 'Browse',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                                'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => 'original',
                                'imageContainer' => '.img',
                                'pasteData' => FileInput::DATA_ID
                            ]);
                            ?>
                        </div>
                        <div class="col-lg-4" style="margin-top:7px">
                            <div class="box-custome-checkbox">
                                <?php
                                echo Html::label($entertainment->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('Entertainment[status]', $entertainment->status, [
                                    'id' => 'status',
                                    'class' => 'tgl tgl-light custome-checkbox',
                                    'value' => ($entertainment->status) ? $entertainment->status : 0,
                                ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo $form->field($entertainment, 'description')->widget(TinyMce::className(), [
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
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="<?php echo Url::to(['/referenceBooks/entertainment']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <?php echo Html::resetButton('Сбросить', ['class' => 'btn btn-primary']) ?>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>