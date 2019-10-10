<?php

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\filemanager\widgets\FileInput;
use backend\modules\referenceBooks\models\Region;
use yii\helpers\ArrayHelper;

$this->title = 'Добавление страны';

$this->params['breadcrumbs'][] = ['label' => 'Справочник стран', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referenceBooks-country-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'country-form', 'method' => 'POST']); ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Общая информация</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Данные для карты</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Города</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <?php echo $form->field($country, 'code'); ?>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <?php echo $form->field($country, 'name'); ?>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <?php echo $form->field($country, 'alias'); ?>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <?php
                                echo $form->field($country, 'media_id')->widget(FileInput::className(), [
                                    'buttonTag' => 'button',
                                    'buttonName' => 'Browse',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => 'original',
                                    'imageContainer' => '.img',
                                    'pasteData' => FileInput::DATA_ID
                                ]);
                                ?>
                            </div>
                            <div class="col-lg-6 col-md-4">
                                <div style="display: flex;">
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($country->getAttributeLabel('visa'), 'visa', ['class' => 'tgl-btn']) . Html::checkbox('Country[visa]', $country->visa, [
                                            'id' => 'visa',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($country->visa) ? $country->visa : 0,
                                        ]) . Html::label('', 'visa', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($country->getAttributeLabel('status'), 'status', ['class' => 'tgl-btn']) . Html::checkbox('Country[status]', $country->status, [
                                            'id' => 'status',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($country->status) ? $country->status : 0,
                                        ]) . Html::label('', 'status', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                    <div class="box-custome-checkbox">
                                        <?php
                                        echo Html::label($country->getAttributeLabel('sync'), 'sync', ['class' => 'tgl-btn']) . Html::checkbox('Country[sync]', $country->sync, [
                                            'id' => 'sync',
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => ($country->sync) ? $country->sync : 0,
                                        ]) . Html::label('', 'sync', ['class' => 'tgl-btn']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                echo $form->field($country, 'country_description')->widget(TinyMce::className(), [
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
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                echo $form->field($country, 'doc_description')->widget(TinyMce::className(), [
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
                                ]);
                                ?>
                            </div>
                        </div>
                        <?php
                        echo $form->field($country, 'visa_description')->widget(TinyMce::className(), [
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
                        ]);
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo $form->field($country, 'alpha_3_code'); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($country, 'region_id')->dropDownList(ArrayHelper::map(Region::find()->all(), 'id', 'name'), ['prompt'=>'Выберите рерион']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <?php echo $form->field($country, 'lat')->textInput(['type' => 'number']); ?>
                        <?php echo $form->field($country, 'lng')->textInput(['type' => 'number']); ?>
                        <?php echo $form->field($country, 'zoom')->textInput(['type' => 'number']); ?>
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <?php if (Yii::$app->controller->action->id === 'create'): ?>
                            Города отсутствуют
                        <?php else: ?>
                            <table id="sortable" class="table" data-url="<?php echo Url::toRoute(['update-position'], TRUE); ?>">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="95%">Город</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($country->city as $v): ?>
                                        <tr id="item-<?php echo $v['cid']; ?>">
                                            <td><?php echo $v->cid; ?></td>
                                            <td><?php echo $v->name; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="<?php echo Url::to(['/referenceBooks/country']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <?php echo Html::resetButton('Сбросить', ['class' => 'btn btn-primary']) ?>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>