<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\forms\ReviewsForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Редактирование отзыва';
$this->params['breadcrumbs'][] = ['label' => 'Список отзывов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="reviews-form">
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Основные поля</h3>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'text')->widget(TinyMce::className(), [
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
                    ])->label('Контент'); ?>

                </div>
            </div>
        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary mr-15']) ?>
        <?= Html::a('Отменить', ['/user/reviews/index'], ['class' => 'btn btn-danger mr-15']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>