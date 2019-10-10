<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Добавление типа транспорта';

$this->params['breadcrumbs'][] = ['label' => 'Справочник типов транспорта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referenceBooks-transport-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'entertainment-form', 'method' => 'POST']); ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $form->field($transport, 'code'); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $form->field($transport, 'name'); ?>
                        </div>
                        <div class="col-md-4">
                            <div class="box-custome-checkbox">
                                <?php
                                echo Html::label($transport->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('Transport[status]', $transport->status, [
                                    'id' => 'status',
                                    'class' => 'tgl tgl-light custome-checkbox',
                                    'value' => ($transport->status) ? $transport->status : 0,
                                ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a href="<?php echo Url::to(['/referenceBooks/transport']) ?>" class="btn btn-primary">Вернуться к списку</a>
                        <?php echo Html::resetButton('Сбросить', ['class' => 'btn btn-primary']) ?>
                        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>