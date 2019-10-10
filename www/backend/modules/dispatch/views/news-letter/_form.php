<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\dispatch\forms\NewsLetterForm*/
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="notifications-form">
    <div class="row">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Текст письма</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'subject')->textInput(); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'send',[
                                        ])->widget('trntv\yii\datetime\DateTimeWidget',[
                                            'phpDatetimeFormat' => 'dd.MM.yyyy, HH:mm',
                                            'clientOptions' => [
                                                'allowInputToggle' => false,
                                                'locale' => 'ru',
                                                'sideBySide' => false,
                                            ]
                                        ]); ?>
                                    </div>
                                </div>

                                <?= $form->field($model, 'body')->widget(TinyMce::className(), [
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
                                ]) ?>

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
