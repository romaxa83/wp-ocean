<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use app\modules\staticBlocks\StaticBlocksAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\staticBlocks\forms\SeoForm*/
/* @var $form yii\widgets\ActiveForm */
/* @var $last_position */
/* @var $count_position */

StaticBlocksAsset::register($this);
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="block-smart-form">
    <div class="row">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Основные поля</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <?= $form->field($model, 'title')->textInput(['class' => 'form-control title-translit']); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'alias')->textInput(['class' => 'form-control alias-translit']); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php if(Yii::$app->controller->action->id == 'create'):?>
                                            <?= $form->field($model, 'position')->textInput(['value' => $last_position + 1,'readonly' => true]); ?>
                                        <?php else:?>
                                            <?= $form->field($model, 'position')->dropDownList(
                                                $model->countPosition($count_position)
                                            ) ?>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <?= $form->field($model, 'description')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 6,'class' => 'field-tiny-mce'],
                                    'language' => 'ru',
                                    'clientOptions' => [
                                        'plugins' => [
                                            "advlist autolink lists link charmap print preview anchor",
                                            "searchreplace visualblocks code fullscreen",
                                            "insertdatetime media table contextmenu paste"
                                        ],
                                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                                    ]
                                ])?>

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
