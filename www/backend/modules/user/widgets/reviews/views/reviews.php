<?php

use backend\modules\filemanager\widgets\FileInput;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use yii\captcha\Captcha;

/* @var $model \backend\modules\user\forms\ReviewsForm */
/* @var $user \common\models\User */
/* @var $hotel_id */
?>

<div class="row collapse in" id="previews">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="wrap-border wrap-reviews">
                    <?php $form = ActiveForm::begin([
                            'options' => [
                            'id' => 'review-form',
                            'data-pjax' => 1,
                            ]
                        ])
                    ?>
                    <?= Html::hiddenInput('ReviewsForm[user_id]', $user->id) ?>
                    <?= Html::hiddenInput('ReviewsForm[hotel_id]', $hotel_id) ?>

                    <?php if(!($user->media_id)):?>
                        <?= $form->field($model, 'media_id')->widget(FileInput::className(), [
                            'buttonTag' => 'button',
                            'buttonName' => 'Выбрать',
                            'buttonOptions' => ['class' => 'btn btn-default'],
                            'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => 'original',
                            'imageContainer' => '.img',
                            'frameSrc' => '/admin/filemanager/file/filemanager',
                            'pasteData' => FileInput::DATA_ID
                        ])->label('Загрузите свое фото'); ?>
                    <?php endif;?>

                    <?= $form->field($model, 'text')->textarea(['rows' => '6'])->label('Оставьте отзыв', ['for' => 'review']) ?>

                    <?= $form->field($model, 'from_date')->widget(DateRangePicker::className(),[
                        'model'=>$model,
                        'language' => 'ru',
                        'attribute'=>'datetime_range',
                        'convertFormat'=>true,
                        'startAttribute'=>'from_date',
                        'endAttribute'=>'to_date',
                        'pluginOptions'=>[
                            'timePicker'=>false,
                            'locale'=>[
                                'format'=>'d/m/Y'
                            ]
                        ]
                    ])->label('Дата пребывание (с-по)') ?>

                    <div class="input-group">
                        <div class="wrap">
                            <div class="rating">
                                <?= $form->field($model, 'rating')->widget(StarRating::classname(), [
                                'pluginOptions' => [
                                'theme' => 'krajee-uni',
                                'filledStar' => '&#x2605;',
                                'emptyStar' => '&#x2606;',
                                'showClear' => false,
                                'showCaption' => false
                                ]
                                ])->label('Оцените отель'); ?>
                            </div>
                        </div>
                    </div>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ])->label('Код для верификации') ?>

                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary mr-15',]) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>