<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\date\DatePicker;

$this->title = 'Добавление тура с API отпуск';
$this->params['breadcrumbs'][] = ['label' => 'Справочник туров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .referenceBooks-tour-index .mr-30 {
        margin-right: 30px;
    }
    .referenceBooks-tour-index .col-type .select2-container {
        flex: 1 1 auto;
        width: initial !important;
    }
    .referenceBooks-tour-index .col-type .box-to {
        margin-left: 30px;
    }
    .referenceBooks-tour-index .select2-search__field {
        width: 100% !important;
    }
    .referenceBooks-tour-index table th {
        white-space: nowrap;
    }
</style>
<div class="referenceBooks-tour-index">
    <div class="row">
        <div class="col-md-12 mb-15">
            <?php echo Html::a('Вернуться к списку', ['/referenceBooks/tour'], ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php
                            echo Select2::widget([
                                'name' => 'deptCity',
                                'data' => $dept_city,
                                'options' => ['placeholder' => 'Выбрать город отправления ...'],
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-type" style="display: flex; flex-wrap: wrap;">
                        <div class="form-group" style="flex-grow: 1;">
                            <?php
                            echo Select2::widget([
                                'name' => 'type',
                                'data' => [
                                    'country' => 'Страна',
                                    'city' => 'Курорт',
                                    'hotel' => 'Отель'
                                ],
                                'options' => ['placeholder' => 'Выбрать тип ...', 'style' => 'flex: 1 1 auto', 'id' => 'filter-to'],
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="form-group box-to hide" style="flex-grow: 1;">

                            <?php
                            echo Select2::widget([
                                'initValueText' => [],
                                'name' => 'country',
                                'options' => ['placeholder' => 'Выбрать страну ...', 'style' => 'flex: 1 1 auto', 'class' => 'filter-country hide'],
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'ajax' => [
                                        'url' => Url::to(['get-country-list']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                    ],
                                ],
                            ]);
                            ?>

                        </div>
                        <div class="form-group box-to hide" style="flex-grow: 1;">
                            <?php
                            echo Select2::widget([
                                'name' => 'city',
                                'options' => ['placeholder' => 'Выбрать курорт ...', 'style' => 'flex: 1 1 auto', 'class' => 'filter-city hide'],
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'ajax' => [
                                        'url' => Url::to(['get-resort-list']),
                                        'dataType' => 'json',
                                        'delay' => 250,
                                        'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                        'cache' => true
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="form-group box-to hide" style="flex-grow: 1;">
                            <?php
                            echo Select2::widget([
                                'name' => 'hotel',
                                'options' => ['placeholder' => 'Выбрать отель ...', 'style' => 'flex: 1 1 auto', 'class' => 'filter-hotel hide'],
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'ajax' => [
                                        'url' => Url::to(['get-hotel-list']),
                                        'dataType' => 'json',
                                        'delay' => 250,
                                        'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                        'cache' => true
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-4">
                        <div class="form-group">
                            <?php
                            echo DatePicker::widget([
                                'name' => 'checkIn',
                                'language' => 'ru',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'options' => ['placeholder' => 'Выбрать «от» ...', 'autocomplete' => 'off', 'readonly' => 'readonly'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="form-group">
                            <?php
                            echo DatePicker::widget([
                                'name' => 'checkTo',
                                'language' => 'ru',
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'options' => ['placeholder' => 'Выбрать «до» ...', 'autocomplete' => 'off', 'readonly' => 'readonly'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="form-group">
                            <input type="number" min="1" max="31" name="length" class="form-control" placeholder="Кол-во ночей">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <input type="number" min="1" name="people" class="form-control" placeholder="Кол-во взрослых">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <?php
                            echo Select2::widget([
                                'name' => 'children',
                                'data' => [
                                    1 => '1 год',
                                    2 => '2 года',
                                    3 => '3 года',
                                    4 => '4 года',
                                    5 => '5 лет',
                                    6 => '6 лет',
                                    7 => '7 лет',
                                    8 => '8 лет',
                                    9 => '9 лет',
                                    10 => '10 лет'
                                ],
                                'options' => ['placeholder' => 'Выбрать возраст детей ...', 'multiple' => true],
                                'language' => 'ru',
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6" style="display: flex; align-items: flex-start;">
                        <div class="mr-30" style="flex: 1 1 auto;">
                            <div class="form-group">
                                <?php
                                echo Select2::widget([
                                    'name' => 'food',
                                    'data' => $type_food,
                                    'options' => ['placeholder' => 'Выбрать питание ...', 'multiple' => true],
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                        <button class="btn mr-15 search-form" type="button">Поиск <i class="glyphicon glyphicon-search"></i></button>
                        <a href="<?php echo Url::toRoute('create-api-tour', TRUE); ?>" class="btn" style="background-color: #dddddd; color: #3a3a3a;">Очистить</a>
                    </div>
                </div>
                <div style="overflow-x: scroll;">
                    <div id="tour-api"></div>
                </div>
                <div class="tour-api-error-box"></div>
                <div class="loader hide"></div>
                <div class="text-center">
                    <button class="btn search-form page hide" type="button" data-page="2">Загрузить еще</button>
                </div>
            </form>
        </div>
    </div>
</div>