<?php

use app\modules\faq\FaqAsset;
use backend\modules\filemanager\widgets\FileInput;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\faq\models\Category*/
/* @var $form yii\widgets\ActiveForm */

FaqAsset::register($this);
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="faq-category-form">
    <div class="row">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Основные поля</h3>
                            </div>
                            <div class="box-body">
                                <?= $form->field($model, 'name')->textInput(['class' => 'form-control title-translit']); ?>

                                <?= $form->field($model, 'alias')->textInput(['class' => 'form-control alias-translit','maxlength' => true]) ?>

                                <?= $form->field($model, 'position')->textInput([
                                    'type' => 'number',
                                    'min' => 0,
                                    'readonly' => $model->isNewRecord ? true : false,
                                    'value' => $model->isNewRecord ? $model->getLastPosition(): $model->position
                                ]) ?>

                                <?= $form->field($model, 'media_id')->widget(FileInput::className(), [
                                    'buttonTag' => 'button',
                                    'buttonName' => 'Browse',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.svg',
                                    'pasteData' => FileInput::DATA_ID
                                ]) ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить',['class' => 'btn btn-primary mr-15',]) ?>
                    <?= Html::resetButton('Сбросить', ['class' => 'btn btn-primary mr-15']) ?>
                    <a href="<?= Url::to(['index']) ?>" class="btn btn-primary">Вернуться к списку</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>