<?php

use backend\modules\user\helpers\SexHelper;
use yii\helpers\Html;
use kartik\date\DatePicker;
use backend\modules\filemanager\widgets\FileInput;

/* @var $model backend\modules\user\forms\IntPassportForm */
/* @var $countForms */
?>
<div class="row">
    <div class="col-lg-12">

        <form id="form-int-passports" action="/site/create-int-passport" method="post">

            <?php for($i = 0; $i < $countForms; $i++):?>

                <div class="form-box">
                    <div class="row">
        <!-- SEX -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label" for="passport-sex_name_<?=$i?>">Пол</label>
                                <?= Html::dropDownList('IntPassportForm['.$i.'][sex]', 'null', SexHelper::list());?>
                                <div class="help-block"></div>
                            </div>
                        </div>
        <!-- FIRST_NAME -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label" for="passport-first_name_<?=$i?>">Имя</label>
                                <input type="text"
                                       id="passport-first_name_<?=$i?>"
                                       class="form-control"
                                       name="IntPassportForm[<?=$i?>][first_name]"
                                       autofocus=""
                                       aria-required="true"
                                       aria-invalid="false">

                                <div class="help-block"></div>
                            </div>
                        </div>
        <!-- LAST_NAME -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label" for="passport-last_name_<?=$i?>">Фамилия</label>
                                <input type="text"
                                       id="passport-last_name_<?=$i?>"
                                       class="form-control"
                                       name="IntPassportForm[<?=$i?>][last_name]"
                                       autofocus=""
                                       aria-required="true"
                                       aria-invalid="false">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
        <!-- BIRTHDAY -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label">День рождения</label>
                                <?= DatePicker::widget([
                                    'name' => 'IntPassportForm['.$i.'][birthday]',
                                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'dd/mm/yyyy'
                                    ]
                                ]);?>
                            </div>
                        </div>
        <!-- SERIES -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label" for="passport-series_<?=$i?>">Серия</label>
                                <input type="text"
                                    id="passport-series_<?=$i?>"
                                    class="form-control"
                                    name="IntPassportForm[<?=$i?>][series]"
                                    autofocus=""
                                    aria-required="true"
                                    aria-invalid="false">

                                <div class="help-block"></div>
                            </div>
                        </div>
        <!-- NUMBER -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label" for="passport-number_<?=$i?>">Номер</label>
                                <input type="text"
                                       id="passport-number_<?=$i?>"
                                       class="form-control"
                                       name="IntPassportForm[<?=$i?>][number]"
                                       autofocus=""
                                       aria-required="true"
                                       aria-invalid="false">

                                <div class="help-block"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
        <!-- ISSUED_DATE -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label">Дата выдачи</label>
                                <?= DatePicker::widget([
                                    'name' => 'IntPassportForm['.$i.'][issued_date]',
                                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'dd/mm/yyyy'
                                    ]
                                ]);?>
                            </div>
                        </div>
        <!-- EXPIRED_DATE -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label">Срок действия</label>
                                <?= DatePicker::widget([
                                    'name' => 'IntPassportForm['.$i.'][expired_date]',
                                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'dd/mm/yyyy'
                                    ]
                                ]);?>
                            </div>
                        </div>
        <!-- ISSUED -->
                        <div class="col-lg-4">
                            <div class="form-group required has-success">
                                <label class="control-label" for="passport-number_<?=$i?>">Кем выдан</label>
                                <input type="text"
                                       id="passport-issued_<?=$i?>"
                                       class="form-control"
                                       name="IntPassportForm[<?=$i?>][issued]"
                                       autofocus=""
                                       aria-required="true"
                                       aria-invalid="false">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <?php if(isVerifyIntPassport()):?>
                        <div class="row">
        <!-- MEDIA -->
                            <div class="col-lg-4">
                                <div class="form-group required has-success">
                                    <label class="control-label">Загрузить скан</label>
                                    <?= FileInput::widget([
                                        'buttonTag' => 'button',
                                        'buttonName' => 'Выбрать',
                                        'name' => 'IntPassportForm['.$i.'][media_id]',
                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                        'options' => [
                                            'class' => 'form-control',
                                            'readonly' => 'readonly',
                                        ],
                                        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                        'thumb' => 'original',
                                        'imageContainer' => '.img',
                                        'frameSrc' => '/admin/filemanager/file/filemanager',
                                        'pasteData' => FileInput::DATA_ID
                                    ]);?>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
                <hr>
            <?php endfor;?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'count-forms','value' => $countForms]) ?>
                <?= Html::a('Вернуться', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
            </div>
        </form>
    </div>
</div>