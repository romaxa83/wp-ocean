<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\filemanager\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\staticBlocks\forms\CompanyForm*/
/* @var $form yii\widgets\ActiveForm */

$this->title ='Редактирование секции видео,блока "О компании"';
$this->params['breadcrumbs'][] = ['label' => 'Список секций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="block-counter-form">
    <div class="row">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Основные поля</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <?= $form->field($model, 'title')->widget(FileInput::className(), [
                                            'buttonTag' => 'button',
                                            'buttonName' => 'Загрузить',
                                            'buttonOptions' => ['class' => 'btn btn-default'],
                                            'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                                            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                            'thumb' => 'original',
                                            'imageContainer' => '.img',
                                            'pasteData' => FileInput::DATA_ID
                                        ]); ?>
                                    </div>
                                    <div class="col-md-5">
                                        <?= $form->field($model, 'description')->widget(FileInput::className(), [
                                            'buttonTag' => 'button',
                                            'buttonName' => 'Загрузить',
                                            'buttonOptions' => ['class' => 'btn btn-default'],
                                            'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                                            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                            'thumb' => 'original',
                                            'imageContainer' => '.mp4',
                                            'pasteData' => FileInput::DATA_ID
                                        ])->hint('Для корректной работы формат видео должен быть .mp4 и не больше 15Mb'); ?>
                                    </div>
                                    <div class="col-md-2">
                                        <?= $form->field($model, 'position')->dropDownList(
                                            $model->listPosition()
                                        ) ?>
                                    </div>
                                </div>
                                <?= Html::hiddenInput('CompanyForm[alias]', 'video') ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить',['class' => 'btn btn-primary mr-15',]) ?>
                    <a href="<?= Url::to(['index']) ?>" class="btn btn-primary">Вернуться к списку</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
