<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use dosamigos\tinymce\TinyMce;

$this->title = 'Добавление тип питания';

$this->params['breadcrumbs'][] = ['label' => 'Справочник тип питания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referenceBooks-type-food-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'type-food-form', 'method' => 'POST']); ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-lg-4">
                            <?php echo $form->field($type_food, 'code'); ?>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <?php echo $form->field($type_food, 'name'); ?>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div style="display: flex;">
                                <div class="box-custome-checkbox">
                                    <?php
                                    echo Html::label($type_food->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('TypeFood[status]', $type_food->status, [
                                        'id' => 'status',
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => ($type_food->status) ? $type_food->status : 0,
                                    ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                    ?>
                                </div>
                                <div class="box-custome-checkbox">
                                    <?php
                                    echo Html::label($type_food->getAttributeLabel('sync'), 'sync', ['class' => 'tgl-btn']) . Html::checkbox('TypeFood[sync]', $type_food->sync, [
                                        'id' => 'sync',
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => ($type_food->sync) ? $type_food->sync : 0,
                                    ]) . Html::label('', 'sync', ['class' => 'tgl-btn']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo $form->field($type_food, 'description')->widget(TinyMce::className(), [
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
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a href="<?php echo Url::to(['/referenceBooks/type-food']) ?>" class="btn btn-primary">Вернуться к списку</a>
                        <?php echo Html::resetButton('Сбросить', ['class' => 'btn btn-primary']) ?>
                        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>