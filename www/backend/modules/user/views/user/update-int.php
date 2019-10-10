<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use backend\modules\user\helpers\SexHelper;
use backend\modules\blog\helpers\ImageHelper;

/* @var $this yii\web\View */
/* @var $passport backend\modules\user\entities\IntPassport */
/* @var $model backend\modules\user\forms\IntPassportForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Редактирование загранпаспорта';
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="passport-int-form">
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Основные поля</h3>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'sex')->dropDownList(SexHelper::list())->label('Пол') ?>

                    <?= $form->field($model, 'first_name')->textInput()->label('Имя') ?>

                    <?= $form->field($model, 'last_name')->textInput()->label('Фамилия') ?>

                    <?= $form->field($model, 'birthday')->widget(DatePicker::className(),[
                        'language' => 'ru',
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'dd/mm/yyyy'
                        ]
                    ])->label('Год рождения') ?>


                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'series')->textInput()->label('Серия') ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'number')->textInput()->label('Номер') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'issued_date')->widget(DatePicker::className(),[
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'dd/mm/yyyy'
                                ]
                            ])->label('Когда выдан') ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'expired_date')->widget(DatePicker::className(),[
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'dd/mm/yyyy'
                                ]
                            ])->label('Срок действия') ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'issued')->textarea(['row' => 2])->label('Кем выдан') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary mr-15']) ?>
                        <?= Html::a('Вернуться', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>

                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
        <?php if(isVerifyIntPassport()):?>
            <div class="col-lg-6">
                <div class="box">
                    <?php if($passport->media_id !== null):?>
                        <div class="box-header with-border">Скан</div>
                            <div class="box-body"><?= ImageHelper::renderImg($passport->media->thumbs,'large')?></div>
                        <?php else:?>
                            <div class="box-header with-border">Скан не загружен</div>
                            <div class="box-body"><?= ImageHelper::notImg()?></div>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>

    </div>

</div>
