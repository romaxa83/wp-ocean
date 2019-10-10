<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use backend\modules\filemanager\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\referenceBooks\models\TypeHotel */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'Добавление типа для отеля' : 'Редактирование типа отеля : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Список типов отеля', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="referenceBooks-type-hotel-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-lg-3">
                            <?= $form->field($model, 'code'); ?>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <?= $form->field($model, 'name'); ?>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <?=
                            $form->field($model, 'media_id')->widget(FileInput::className(), [
                                'buttonTag' => 'button',
                                'buttonName' => 'Browse',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                                'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => 'original',
                                'imageContainer' => '.img',
                                'pasteData' => FileInput::DATA_ID
                            ])->label('Обложка');
                            ?>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div style="display: flex;">
                                <div class="box-custome-checkbox required">
                                    <?=
                                    Html::label($model->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('TypeHotel[status]', $model->status, [
                                        'id' => 'status',
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => ($model->status) ? $model->status : 0,
                                    ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                    ?>
                                </div>
                                <div class="box-custome-checkbox required">
                                    <?=
                                    Html::label($model->getAttributeLabel('sync'), 'sync', ['class' => 'tgl-btn']) . Html::checkbox('TypeHotel[sync]', $model->sync, [
                                        'id' => 'sync',
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => ($model->sync) ? $model->sync : 0,
                                    ]) . Html::label('', 'sync', ['class' => 'tgl-btn']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=
                    $form->field($model, 'description')->widget(TinyMce::className(), [
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
            <div class="form-group">
                <a href="<?= Url::to(['/referenceBooks/type-hotel']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <?= Html::resetButton('Сбросить', ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>