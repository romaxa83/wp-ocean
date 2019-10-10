<?php

use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;

$this->title = 'Добавление фильтра';
$this->params['breadcrumbs'][] = ['label' => 'Фильтр', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-data-form">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'filter-data-form', 'method' => 'POST']); ?>
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $form->field($filter, 'link', ['enableAjaxValidation' => true])->textInput(['readonly' => true]); ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->field($filter, 'alias', ['enableAjaxValidation' => true])->textInput(['readonly' => (Yii::$app->controller->action->id == 'update') ? true : false]);
                            ;
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $form->field($filter, 'name'); ?>
                        </div>
                    </div>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Основные параметры</a></li>
                            <li><a href="#tab_2" id="extra_options" data-toggle="tab" aria-expanded="false">Дополнительные параметры</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Страны прибытия</a></li>
                                                <li><a href="#tab_1_2" data-toggle="tab" aria-expanded="true">Города отправления</a></li>
                                                <li><a href="#tab_1_3" data-toggle="tab" aria-expanded="true">Даты</a></li>
                                                <li><a href="#tab_1_4" data-toggle="tab" aria-expanded="true">Количество ночей</a></li>
                                                <li><a href="#tab_1_5" data-toggle="tab" aria-expanded="true">Количество туристов</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1_1">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label" for="filter-country-priority-limit">Количество приоритетных стран</label>
                                                                <input type="number" min="0" id="filter-country-priority-limit" class="form-control" name="Country[priority]" value="<?php echo (isset($filter->country['priority'])) ? $filter->country['priority'] : 0; ?>">
                                                            </div>
                                                            <div class="overflow">
                                                                <?php
                                                                echo GridView::widget([
                                                                    'id' => 'filter_country',
                                                                    'dataProvider' => $dataProviderCountry,
                                                                    'tableOptions' => [
                                                                        'class' => 'table sortable'
                                                                    ],
                                                                    'columns' => [
                                                                        ['class' => 'yii\grid\SerialColumn'],
                                                                        [
                                                                            'attribute' => 'Позиция',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%'],
                                                                            'contentOptions' => ['class' => 'position'],
                                                                            'value' => function($model) use ($filter) {
                                                                                return '<i class="fa fa-arrows" aria-hidden="true"></i>';
                                                                            }
                                                                        ],
                                                                        [
                                                                            'attribute' => 'name',
                                                                            'headerOptions' => ['width' => '100%'],
                                                                            'value' => function($model) {
                                                                                return $model['name'];
                                                                            }
                                                                        ],
                                                                        [
                                                                            'attribute' => 'Статус',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%', 'class' => 'box-check-all'],
                                                                            'value' => function($model) use ($filter) {
                                                                                $value = 0;
                                                                                if (isset($filter->country['country'])) {
                                                                                    $value = (array_search($model['id'], $filter->country['country']) !== FALSE) ? 1 : 0;
                                                                                }
                                                                                return Html::checkbox('Country[country][' . $model['id'] . ']', $value, [
                                                                                            'id' => 'country_status_' . $model['id'],
                                                                                            'class' => 'tgl tgl-light custome-checkbox custome-checkbox-status country_status',
                                                                                            'value' => $value,
                                                                                        ]) . Html::label('', 'country_status_' . $model['id'], ['class' => 'tgl-btn']);
                                                                            }
                                                                        ],
                                                                        [
                                                                            'attribute' => 'По yмолчанию',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%'],
                                                                            'contentOptions' => ['class' => 'position'],
                                                                            'value' => function($model) use ($filter) {
                                                                                $value = 0;
                                                                                if (isset($filter->country['default'])) {
                                                                                    if ($model['id'] == $filter->country['default']) {
                                                                                        $value = 1;
                                                                                    }
                                                                                }
                                                                                $value_status = 0;
                                                                                if (isset($filter->country['country'])) {
                                                                                    $value_status = (array_search($model['id'], $filter->country['country']) !== FALSE) ? 1 : 0;
                                                                                }
                                                                                return Html::radio('Country[default]', $value, [
                                                                                            'id' => 'country_default_' . $model['id'],
                                                                                            'class' => 'tgl tgl-light custom-radio',
                                                                                            'value' => $model['id'],
                                                                                            'disabled' => ($value_status == 0) ? TRUE : FALSE,
                                                                                            (($value == 1) ? 'checked="checked"' : ''),
                                                                                        ]) . Html::label('', 'country_default_' . $model['id']);
                                                                            }
                                                                        ]
                                                                    ]
                                                                ]);
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_1_2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="overflow">
                                                                <?php
                                                                echo GridView::widget([
                                                                    'id' => 'filter_dept_city',
                                                                    'dataProvider' => $dataProviderDeptCity,
                                                                    'tableOptions' => [
                                                                        'class' => 'table sortable'
                                                                    ],
                                                                    'columns' => [
                                                                        ['class' => 'yii\grid\SerialColumn'],
                                                                        [
                                                                            'attribute' => 'Позиция',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%'],
                                                                            'contentOptions' => ['class' => 'position'],
                                                                            'value' => function($model) {
                                                                                return '<i class="fa fa-arrows" aria-hidden="true"></i>';
                                                                            }
                                                                        ],
                                                                        [
                                                                            'attribute' => 'name',
                                                                            'headerOptions' => ['width' => '100%'],
                                                                            'value' => function($model) {
                                                                                return $model['name'];
                                                                            }
                                                                        ],
                                                                        [
                                                                            'attribute' => 'Статус',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%', 'class' => 'box-check-all'],
                                                                            'value' => function($model) use ($filter) {
                                                                                $value = 0;
                                                                                if (isset($filter->dept_city['dept_city'])) {
                                                                                    $value = (array_search($model['id'], $filter->dept_city['dept_city']) !== FALSE) ? 1 : 0;
                                                                                }
                                                                                return Html::checkbox('DeptCity[dept_city][' . $model['id'] . ']', $value, [
                                                                                            'id' => 'dept_city_status_' . $model['id'],
                                                                                            'class' => 'tgl tgl-light custome-checkbox custome-checkbox-status',
                                                                                            'value' => $value,
                                                                                        ]) . Html::label('', 'dept_city_status_' . $model['id'], ['class' => 'tgl-btn']);
                                                                            }
                                                                        ],
                                                                        [
                                                                            'attribute' => 'По yмолчанию',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%'],
                                                                            'contentOptions' => ['class' => 'position'],
                                                                            'value' => function($model) use ($filter) {
                                                                                $value = 0;
                                                                                if (isset($filter->dept_city['default'])) {
                                                                                    if ($model['id'] == $filter->dept_city['default']) {
                                                                                        $value = 1;
                                                                                    }
                                                                                }
                                                                                $value_status = 0;
                                                                                if (isset($filter->dept_city['dept_city'])) {
                                                                                    $value_status = (array_search($model['id'], $filter->dept_city['dept_city']) !== FALSE) ? 1 : 0;
                                                                                }
                                                                                return Html::radio('DeptCity[default]', $value, [
                                                                                            'id' => 'dept_city_default_' . $model['id'],
                                                                                            'class' => 'tgl tgl-light custom-radio',
                                                                                            'value' => $model['id'],
                                                                                            'disabled' => ($value_status == 0) ? TRUE : FALSE,
                                                                                            (($value == 1) ? 'checked="checked"' : ''),
                                                                                        ]) . Html::label('', 'dept_city_default_' . $model['id']);
                                                                            }
                                                                        ],
                                                                    ]
                                                                ]);
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_1_3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label" for="date-day">Количество дней от текущей даты</label>
                                                                <div>
                                                                    <?php echo DatePicker::widget([
                                                                        'name' => 'Date[from]',
                                                                        'type' => DatePicker::TYPE_INPUT,
                                                                        'value' => (isset($filter->date['from'])) ? $filter->date['from'] : date('d.m.Y', strtotime('+14 days')),
                                                                        'id' => 'date-from',
                                                                        'options' => ['style' => 'width: 100px; display: inline-block;'],
                                                                        'pluginOptions' => [
                                                                            'format' => 'dd.mm.yyyy',
                                                                            'todayHighlight' => true,
                                                                            'autoclose' => true,
                                                                        ]
                                                                    ]);
                                                                    ?> +
                                                                    <input type="number" min="0" id="date-day" class="form-control" value="<?php echo (isset($filter->date['default'])) ? $filter->date['default'] : 14; ?>" style="width: 100px; display: inline-block;" name="Date[default]">
                                                                </div>
                                                                <div style="margin-bottom: 5px;">
                                                                    <input type="text" id="date-date-from" class="form-control" value="<?php echo (isset($filter->date['from'])) ? $filter->date['from'] : date('d.m.Y'); ?>" style="width: 100px; display: inline-block;" readonly="readonly"> &ndash;
                                                                    <input type="text" id="date-date-to" class="form-control" value="<?php echo date('d.m.Y'); ?>" style="width: 100px; display: inline-block;" readonly="readonly">
                                                                </div>
                                                                <div>
                                                                    <?php echo Html::checkbox('Date[checked]', isset($filter->date['checked']) ? $filter->date['checked'] : 0,
                                                                        ['label' => 'Автоматически добавлять к дате выезда от и до 1 день каждые сутки',]);?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_1_4">
                                                    <div class="row">
                                                        <input type="hidden" value="0" name="Length[length][]">
                                                        <input type="hidden" value="0" name="Length[default]">
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Минимальное количество ночей</label>
                                                            <input type="number" min="1" max="21" class="form-control" value="<?php echo (isset($filter->length['min'])) ? $filter->length['min'] : 1; ?>" name="Length[min]">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Максимальное количество ночей</label>
                                                            <input type="number" min="1" max="21" class="form-control" value="<?php echo (isset($filter->length['max'])) ? $filter->length['max'] : 21; ?>" name="Length[max]">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label class="control-label">Допустимый диапазон</label>
                                                            <?php
                                                            $range = [];
                                                            for ($i = 1; $i <= 7; $i++) {
                                                                $range[$i] = $i;
                                                            }
                                                            echo Select2::widget([
                                                                'id' => 'range',
                                                                'name' => 'Length[range]',
                                                                'value' => ((isset($filter->length['range'])) ? $filter->length['range'] : 7),
                                                                'data' => $range,
                                                                'options' => ['placeholder' => 'Выбрать допустимый диапазон ...']
                                                            ]);
                                                            ?>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Количество ночей по умолчанию от</label>
                                                            <input type="number" min="1" max="21" class="form-control" value="<?php echo (isset($filter->length['min_default'])) ? $filter->length['min_default'] : 6 ?>" name="Length[min_default]">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Количество ночей по умолчанию до</label>
                                                            <input type="number" min="1" max="21" class="form-control" value="<?php echo (isset($filter->length['max_default'])) ? $filter->length['max_default'] : 7 ?>" name="Length[max_default]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_1_5">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label" for="filter-people-limit">Количество взрослых по умолчанию</label>
                                                                <input type="number" min="0" id="filter-people-limit" class="form-control" name="People[default]" value="<?php echo (isset($filter->people['default'])) ? $filter->people['default'] : 1; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a href="#tab_2_1" data-toggle="tab" aria-expanded="true">Категории отелей</a></li>
                                                <li><a href="#tab_2_2" data-toggle="tab" aria-expanded="true">Питание</a></li>
                                                <li><a href="#tab_2_3" data-toggle="tab" aria-expanded="true">Курорты</a></li>
                                                <li><a href="#tab_2_4" data-toggle="tab" aria-expanded="true">Отели</a></li>
                                                <li><a href="#tab_2_5" data-toggle="tab" aria-expanded="true">Цена</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_2_1">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php
                                                            echo GridView::widget([
                                                                'dataProvider' => $dataProviderCategory,
                                                                'tableOptions' => [
                                                                    'class' => 'table sortable'
                                                                ],
                                                                'columns' => [
                                                                    ['class' => 'yii\grid\SerialColumn'],
                                                                    [
                                                                        'attribute' => 'Позиция',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '5%'],
                                                                        'contentOptions' => ['class' => 'position'],
                                                                        'value' => function($model) {
                                                                            return '<i class="fa fa-arrows" aria-hidden="true"></i>';
                                                                        }
                                                                    ],
                                                                    [
                                                                        'attribute' => 'name',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '100%'],
                                                                        'value' => function($model) {
                                                                            return $model['name'];
                                                                        }
                                                                    ],
                                                                    [
                                                                        'attribute' => 'Статус',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '5%', 'class' => 'box-check-all'],
                                                                        'value' => function($model) use ($filter) {
                                                                            $value = 0;
                                                                            if (isset($filter->category['category'])) {
                                                                                $value = (array_search($model['id'], $filter->category['category']) !== FALSE) ? 1 : 0;
                                                                            }
                                                                            return Html::checkbox('Category[category][' . $model['id'] . ']', $value, [
                                                                                        'id' => 'category_status_' . $model['id'],
                                                                                        'class' => 'tgl tgl-light custome-checkbox custome-checkbox-status',
                                                                                        'value' => $model['id'],
                                                                                    ]) . Html::label('', 'category_status_' . $model['id'], ['class' => 'tgl-btn']);
                                                                        }
                                                                    ],
                                                                    [
                                                                        'attribute' => 'По yмолчанию',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '5%'],
                                                                        'contentOptions' => ['class' => 'position'],
                                                                        'value' => function($model) use ($filter) {
                                                                            $value = 0;
                                                                            if (isset($filter->category['default'])) {
                                                                                if ($model['id'] == $filter->category['default']) {
                                                                                    $value = 1;
                                                                                }
                                                                            }
                                                                            $value_status = 0;
                                                                            if (isset($filter->category['category'])) {
                                                                                $value_status = (array_search($model['id'], $filter->category['category']) !== FALSE) ? 1 : 0;
                                                                            }
                                                                            return Html::radio('Category[default]', $value, [
                                                                                        'id' => 'category_default_' . $model['id'],
                                                                                        'class' => 'tgl tgl-light custom-radio',
                                                                                        'value' => $model['id'],
                                                                                        'disabled' => ($value_status == 0) ? TRUE : FALSE,
                                                                                        (($value == 1) ? 'checked="checked"' : ''),
                                                                                    ]) . Html::label('', 'category_default_' . $model['id']);
                                                                        }
                                                                    ]
                                                                ]
                                                            ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_2_2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php
                                                            echo GridView::widget([
                                                                'dataProvider' => $dataProviderTypeFood,
                                                                'tableOptions' => [
                                                                    'class' => 'table sortable'
                                                                ],
                                                                'columns' => [
                                                                    ['class' => 'yii\grid\SerialColumn'],
                                                                    [
                                                                        'attribute' => 'Позиция',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '5%'],
                                                                        'contentOptions' => ['class' => 'position'],
                                                                        'value' => function($model) {
                                                                            return '<i class="fa fa-arrows" aria-hidden="true"></i>';
                                                                        }
                                                                    ],
                                                                    [
                                                                        'attribute' => 'name',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '100%'],
                                                                        'value' => function($model) {
                                                                            return $model['name'];
                                                                        }
                                                                    ],
                                                                    [
                                                                        'attribute' => 'Статус',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '5%', 'class' => 'box-check-all'],
                                                                        'value' => function($model) use ($filter) {
                                                                            $value = 0;
                                                                            if (isset($filter->food['food'])) {
                                                                                $value = (array_search($model['id'], $filter->food['food']) !== FALSE) ? 1 : 0;
                                                                            }
                                                                            return Html::checkbox('Food[food][' . $model['id'] . ']', $value, [
                                                                                        'id' => 'food_status_' . $model['id'],
                                                                                        'class' => 'tgl tgl-light custome-checkbox custome-checkbox-status',
                                                                                        'value' => $model['id'],
                                                                                    ]) . Html::label('', 'food_status_' . $model['id'], ['class' => 'tgl-btn']);
                                                                        }
                                                                    ],
                                                                    [
                                                                        'attribute' => 'По yмолчанию',
                                                                        'format' => 'raw',
                                                                        'headerOptions' => ['width' => '5%'],
                                                                        'contentOptions' => ['class' => 'position'],
                                                                        'value' => function($model) use ($filter) {
                                                                            $value = 0;
                                                                            if (isset($filter->food['default'])) {
                                                                                if ($model['id'] == $filter->food['default']) {
                                                                                    $value = 1;
                                                                                }
                                                                            }
                                                                            $value_status = 0;
                                                                            if (isset($filter->food['food'])) {
                                                                                $value_status = (array_search($model['id'], $filter->food['food']) !== FALSE) ? 1 : 0;
                                                                            }
                                                                            return Html::radio('Food[default]', $value, [
                                                                                        'id' => 'food_default_' . $model['id'],
                                                                                        'class' => 'tgl tgl-light custom-radio',
                                                                                        'value' => $model['id'],
                                                                                        'disabled' => ($value_status == 0) ? TRUE : FALSE,
                                                                                        (($value == 1) ? 'checked="checked"' : ''),
                                                                                    ]) . Html::label('', 'food_default_' . $model['id']);
                                                                        }
                                                                    ]
                                                                ]
                                                            ]);
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_2_3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-15">
                                                                <?php
                                                                echo Select2::widget([
                                                                    'id' => 'city_country_id',
                                                                    'name' => 'City[country_select]',
                                                                    'data' => $countryList,
                                                                    'options' => ['placeholder' => 'Выбрать страну ...'],
                                                                    'pluginOptions' => [
                                                                        'allowClear' => true
                                                                    ],
                                                                ]);
                                                                ?>
                                                            </div>
                                                            <div class="overflow">
                                                                <?php
                                                                echo GridView::widget([
                                                                    'dataProvider' => $dataProviderCity,
                                                                    'tableOptions' => [
                                                                        'id' => 'city_list',
                                                                        'class' => 'table sortable'
                                                                    ],
                                                                    'columns' => [
                                                                        [
                                                                            'attribute' => 'Позиция',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%'],
                                                                            'contentOptions' => ['class' => 'position']
                                                                        ],
                                                                        [
                                                                            'attribute' => 'Название',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '100%']
                                                                        ],
                                                                        [
                                                                            'attribute' => 'Статус',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%', 'class' => 'box-check-all']
                                                                        ],
                                                                        [
                                                                            'attribute' => 'По yмолчанию',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%']
                                                                        ]
                                                                    ]
                                                                ]);
                                                                ?>
                                                            </div>
                                                            <textarea id="city_textarea" readonly="readonly" name="City[city]" style="width: 100%;display: none;" rows="6"><?php echo (isset($filter->city)) ? $filter->city : '{}'; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_2_4">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row mb-15">
                                                                <div class="col-md-6">
                                                                    <?php
                                                                    echo Select2::widget([
                                                                        'id' => 'hotel_country_id',
                                                                        'name' => 'Hotel[country]',
                                                                        'data' => $countryList,
                                                                        'options' => ['placeholder' => 'Выбрать страну ...'],
                                                                        'pluginOptions' => [
                                                                            'allowClear' => true
                                                                        ],
                                                                    ]);
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?php
                                                                    echo Select2::widget([
                                                                        'id' => 'hotel_city_id',
                                                                        'name' => 'Hotel[city]',
                                                                        'data' => [],
                                                                        'options' => ['placeholder' => 'Выбрать город ...'],
                                                                        'pluginOptions' => [
                                                                            'allowClear' => true
                                                                        ],
                                                                    ]);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="overflow">
                                                                <?php
                                                                echo GridView::widget([
                                                                    'dataProvider' => $dataProviderHotel,
                                                                    'tableOptions' => [
                                                                        'id' => 'hotel_list',
                                                                        'class' => 'table sortable'
                                                                    ],
                                                                    'columns' => [
                                                                        [
                                                                            'attribute' => 'Позиция',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%'],
                                                                            'contentOptions' => ['class' => 'position']
                                                                        ],
                                                                        [
                                                                            'attribute' => 'Название',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '100%']
                                                                        ],
                                                                        [
                                                                            'attribute' => 'Статус',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%', 'class' => 'box-check-all']
                                                                        ],
                                                                        [
                                                                            'attribute' => 'По yмолчанию',
                                                                            'format' => 'raw',
                                                                            'headerOptions' => ['width' => '5%']
                                                                        ]
                                                                    ]
                                                                ]);
                                                                ?>
                                                            </div>
                                                            <textarea id="hotel_textarea" readonly="readonly" name="Hotel[hotel]" style="width: 100%; display: none;" rows="6"><?php echo (isset($filter->hotel)) ? $filter->hotel : '{}'; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab_2_5">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label" for="filter-price-from">Цена от</label>
                                                                <input type="number" min="0" id="filter-price-from" class="form-control" name="Price[from]" value="<?php echo (isset($filter->price['from'])) ? $filter->price['from'] : 0; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label" for="filter-price-to">Цена до</label>
                                                                <input type="number" min="0" id="filter-price-to" class="form-control" name="Price[to]" value="<?php echo (isset($filter->price['to'])) ? $filter->price['to'] : 0; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label" for="filter-currency">Валюта по умолчанию</label>
                                                                <select class="form-control" name="Price[currency]" id="price_currency">
                                                                    <option <?php echo (isset($filter->price['currency']) && $filter->price['currency'] == 'UAH') ? 'selected' : ''; ?> value="UAH">UAH</option>
                                                                    <option <?php echo (isset($filter->price['currency']) && $filter->price['currency'] == 'USD') ? 'selected' : ''; ?> value="USD">USD</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <a href="<?php echo Url::to(['/filter/filter']) ?>" class="btn btn-primary">Вернуться к списку</a>
                <a href="#" class="btn btn-primary" onClick="window.location.reload();return false;">Сбросить</a>
                <?php echo Html::button('Сохранить', ['class' => 'btn btn-primary save-filter-btn']); ?>
                <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary save-filter', 'style' => 'display: none;']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
