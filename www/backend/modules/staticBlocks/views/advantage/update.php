<?php

use backend\modules\blog\entities\Category;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\blog\BlogAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\staticBlocks\forms\AdvantageForm*/
/* @var $form yii\widgets\ActiveForm */

$this->title ='Редактирование секции блока "Наши Преимущества"';
$this->params['breadcrumbs'][] = ['label' => 'Список секций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="block-advantage-form">
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
                                <div class="row">
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'title')->textInput(); ?>
                                    </div>
                                    <div class="col-md-offset-2 col-md-2">
                                        <?= $form->field($model, 'position')->dropDownList(
                                            $model->listPosition()
                                        ) ?>
                                    </div>
                                </div>

                                <?= $form->field($model, 'description')->widget(TinyMce::className(), [
                                    'options' => ['rows' => 4, 'class' => 'field-tiny-mce'],
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

                                <?= Html::hiddenInput('AdvantageForm[alias]', $model->alias) ?>

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
