<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\faq\FaqAsset;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\faq\models\Faq*/
/* @var $form yii\widgets\ActiveForm */
FaqAsset::register($this);
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="faq-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <!-- Page Faq -->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="row">
                                <?php if($access->accessInView('faq/faq/change-rate') && $access->accessInView('faq/faq/status-change')):?>
                                    <p class="text-center">Стр. Faq</p>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/change-rate')):?>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'rate_faq')->textInput(['type' => 'number','value' => $model->isNewRecord?'0':$model->rate_faq])->label('Рейтинг'); ?>
                                    </div>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/status-change')):?>
                                    <div class="col-md-6">
                                        <div class="box-custome-checkbox">
                                            <?= Html::label('Опубликовать', 'page-faq', ['class' => 'tgl-btn']) . Html::checkbox('Faq[page_faq]', $model->page_faq, [
                                                'id' => 'page-faq',
                                                'class' => 'tgl tgl-light custome-checkbox',
                                                'value' => ($model->page_faq) ? $model->page_faq : 0,
                                            ]) . Html::label('', 'page-faq', ['class' => 'tgl-btn']); ?>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <!-- Page Vip-Tour -->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="row">
                                <?php if($access->accessInView('faq/faq/change-rate') && $access->accessInView('faq/faq/status-change')):?>
                                    <p class="text-center">Стр. Vip-tour</p>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/change-rate')):?>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'rate_vip')->textInput(['type' => 'number','value' => $model->isNewRecord?'0':$model->rate_vip])->label('Рейтинг'); ?>
                                    </div>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/status-change')):?>
                                    <div class="col-md-6">
                                        <div class="box-custome-checkbox">
                                            <?= Html::label('Опубликовать', 'page-vip', ['class' => 'tgl-btn']) . Html::checkbox('Faq[page_vip]', $model->page_vip, [
                                                'id' => 'page-vip',
                                                'class' => 'tgl tgl-light custome-checkbox',
                                                'value' => ($model->page_vip) ? $model->page_vip : 0,
                                            ]) . Html::label('', 'page-vip', ['class' => 'tgl-btn']); ?>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <!-- Page Exotic-Tour -->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="row">
                                <?php if($access->accessInView('faq/faq/change-rate') && $access->accessInView('faq/faq/status-change')):?>
                                    <p class="text-center">Стр. Exotic-tour</p>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/change-rate')):?>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'rate_exo')->textInput(['type' => 'number','value' => $model->isNewRecord?'0':$model->rate_exo])->label('Рейтинг'); ?>
                                    </div>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/status-change')):?>
                                    <div class="col-md-6">
                                        <div class="box-custome-checkbox">
                                            <?= Html::label('Опубликовать', 'page-exo', ['class' => 'tgl-btn']) . Html::checkbox('Faq[page_exo]', $model->page_exo, [
                                                'id' => 'page-exo',
                                                'class' => 'tgl tgl-light custome-checkbox',
                                                'value' => ($model->page_exo) ? $model->page_exo : 0,
                                            ]) . Html::label('', 'page-exo', ['class' => 'tgl-btn']); ?>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <!-- Page Hot-Tour -->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                            <div class="row">
                                <?php if($access->accessInView('faq/faq/change-rate') && $access->accessInView('faq/faq/status-change')):?>
                                    <p class="text-center">Стр. Hot-tour</p>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/change-rate')):?>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'rate_hot')->textInput(['type' => 'number','value' => $model->isNewRecord?'0':$model->rate_hot])->label('Рейтинг'); ?>
                                    </div>
                                <?php endif;?>
                                <?php if($access->accessInView('faq/faq/status-change')):?>
                                    <div class="col-md-6">
                                        <div class="box-custome-checkbox">
                                            <?= Html::label('Опубликовать', 'page-hot', ['class' => 'tgl-btn']) . Html::checkbox('Faq[page_hot]', $model->page_hot, [
                                                'id' => 'page-hot',
                                                'class' => 'tgl tgl-light custome-checkbox',
                                                'value' => ($model->page_hot) ? $model->page_hot : 0,
                                            ]) . Html::label('', 'page-hot', ['class' => 'tgl-btn']); ?>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model,'category_id')->dropDownList($model->getCategoryList(),[
                                'class' => 'form-control',
                                'prompt' => 'Выберети категорию'
                            ]) ?>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                    <div class="row">
                        <!-- Question -->
                        <div class="col-md-6">
                            <?= $form->field($model, 'question')->widget(TinyMce::className(), [
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
                            ]); ?>
                        </div>
                        <!-- Answer -->
                        <div class="col-md-6">
                            <?= $form->field($model, 'answer')->widget(TinyMce::className(), [
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
                            ]); ?>
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

