<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;
use kartik\date\DatePicker;

/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Справочник туров';
$this->params['breadcrumbs'][] = $this->title;
$main_count = 20;
$main_option = [];
$main_option[99] = '1-20';
for ($i = 0; $i <= $main_count; $i++)
    $main_option[$i] = $i;
$recommend_count = 20;
$recommend_option = [];
$recommend_option[99] = '1-20';
for ($i = 0; $i <= $recommend_count; $i++)
    $recommend_option[$i] = $i;
$hot_count = 20;
$hot_option = [];
$hot_option[99] = '1-20';
for ($i = 0; $i <= $hot_count; $i++)
    $hot_option[$i] = $i;
?>
<div class="referenceBooks-tour-index">
    <div class="row">
        <div class="col-md-12 mb-15">
            <?php if ($access->accessInView(Url::toRoute(['create']))): ?>
                <?php echo Html::a('Добавить тур', ['create'], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
            <?php if ($access->accessInView(Url::toRoute(['create-api-tour']))): ?>
                <?php echo Html::a('Добавить тур c API отпуск', ['create-api-tour'], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
            <?php if ($access->accessInView(Url::toRoute(['delete-checked-tour']))): ?>
                <a class="btn btn-primary" id="delete-checked-tour">Удалить выбранные</a>
            <?php endif; ?>
            <span>Размер шрифта: </span>
            <select id="font-size-changer" onchange="tableFontSizeChanger()">
                <?php
                for ($i = 14; $i >= 8; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <b>Для горизонтального проскролла зажмите SHIFT и покрутите колесо мыши</b>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список туров</h3>
        </div>
        <div class="box-body">
            <?php
            echo GridView::widget([
                'id' => 'tour-table',
                'options' => [
                    'class' => 'grid-view table-flexible',
                    'style' => ['opacity' => 0, 'position', 'absolute']
                ],
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->id;
                        },
                        'contentOptions' => SettingsWidget::setConfig('id', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('id', $user_settings['hide-col'], ['title' => 'ID'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('id', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Заг',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->title;
                        },
                        'contentOptions' => SettingsWidget::setConfig('title', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('title', $user_settings['hide-col'], ['title' => 'Заголовок'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('title', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'label' => 'Страна',
                        'attribute' => 'city_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->city['country']['name'];
                        },
                        'contentOptions' => SettingsWidget::setConfig('country', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('country', $user_settings['hide-col'], ['title' => 'Страна'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('country', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'label' => 'Отель | категория | город | питание',
                        'attribute' => 'hotel_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->hotel['name'] . ' | ' . $model->hotel['category']['name'] . ' | ' . $model->city['name'] . ' | ' . $model->food['name'];
                        },
                        'contentOptions' => SettingsWidget::setConfig('hotel', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('hotel', $user_settings['hide-col'], ['title' => 'Отель | категория | город | питание'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('hotel', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'Тип номера',
                        'filter' => '<input class="form-control" disabled>',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return NULL;
                        },
                        'contentOptions' => SettingsWidget::setConfig('type_number', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('type_number', $user_settings['hide-col'], ['title' => 'Тип номера'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('type_number', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'date_departure',
                        'label' => 'Дата отпр',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'date_departure',
                            'convertFormat' => true,
                            'removeButton' => false,
                            'pluginOptions' => [
                                'orientation' => 'bottom',
                                'autoUpdateInput' => false,
                                'format' => 'dd.MM.yyyy',
                                'autoclose' => true,
                                'weekStart' => 1
                            ]
                        ]),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            $datetime = Yii::$app->formatter->asDatetime($model->date_departure, 'php:d.m.Y H:i:s');
                            $date = Yii::$app->formatter->asDatetime($model->date_departure, 'php:d.m.Y');
                            return "<span title='$datetime'>$date</span>";
                        },
                        'contentOptions' => SettingsWidget::setConfig('date_departure', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('date_departure', $user_settings['hide-col'], ['title' => 'Дата отправления'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('date_departure', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'date_arrival',
                        'label' => 'Дата приб',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'date_arrival',
                            'convertFormat' => true,
                            'removeButton' => false,
                            'pluginOptions' => [
                                'orientation' => 'bottom',
                                'autoUpdateInput' => false,
                                'format' => 'dd.MM.yyyy',
                                'autoclose' => true,
                                'weekStart' => 1
                            ]
                        ]),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            $datetime = Yii::$app->formatter->asDatetime($model->date_arrival, 'php:d.m.Y H:i:s');
                            $date = Yii::$app->formatter->asDatetime($model->date_arrival, 'php:d.m.Y');
                            return "<span title='$datetime'>$date</span>";
                        },
                        'contentOptions' => SettingsWidget::setConfig('date_arrival', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('date_arrival', $user_settings['hide-col'], ['title' => 'Дата прибытия'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('date_arrival', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'length',
                        'label' => 'К н',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->length;
                        },
                        'contentOptions' => SettingsWidget::setConfig('length', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('length', $user_settings['hide-col'], ['title' => 'Кол-во ночей'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('length', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'dept_city_id',
                        'label' => 'Город отпр',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->deptCity['name'];
                        },
                        'contentOptions' => SettingsWidget::setConfig('dept_city_id', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('dept_city_id', $user_settings['hide-col'], ['title' => 'Город отправления'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('dept_city_id', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'type_transport_id',
                        'label' => 'Тип тр-п',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->transport['name'];
                        },
                        'contentOptions' => SettingsWidget::setConfig('type_transport_id', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('type_transport_id', $user_settings['hide-col'], ['title' => 'Тип транспорта'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('type_transport_id', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'operator_id',
                        'label' => 'Оп-р',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->operator['name'];
                        },
                        'contentOptions' => SettingsWidget::setConfig('operator_id', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('operator_id', $user_settings['hide-col'], ['title' => 'Оператор'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('operator_id', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => '% комиссии',
                        'label' => '% ком',
                        'filter' => '<input class="form-control" disabled>',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return NULL;
                        },
                        'contentOptions' => SettingsWidget::setConfig('commission', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('commission', $user_settings['hide-col'], ['title' => '% комиссии'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('commission', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'label' => 'П-д активн',
                        'attribute' => 'date_begin',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' => DatePicker::TYPE_RANGE,
                            'attribute' => 'date_begin',
                            'attribute2' => 'date_end',
                            'pluginOptions' => [
                                'orientation' => 'bottom',
                                'autoUpdateInput' => false,
                                'format' => 'dd.mm.yyyy',
                                'autoclose' => true,
                                'weekStart' => 1
                            ]
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'format' => 'raw',
                        'value' => function($model) {
                            $datetime_begin = Yii::$app->formatter->asDatetime($model->date_begin, 'php:d.m.Y H:i:s');
                            $date_begin = Yii::$app->formatter->asDatetime($model->date_begin, 'php:d.m.Y');
                            $datetime_end = Yii::$app->formatter->asDatetime($model->date_end, 'php:d.m.Y H:i:s');
                            $date_end = Yii::$app->formatter->asDatetime($model->date_end, 'php:d.m.Y');
                            return '<span title="' . $datetime_begin . ' - ' . $datetime_end . '">' . $date_begin . ' - ' . $date_end . '</span>';
                        },
                        'contentOptions' => SettingsWidget::setConfig('date_begin', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('date_begin', $user_settings['hide-col'], ['title' => 'Период активности'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('date_begin', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'date_end_sale',
                        'label' => 'Д оконч продаж',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'date_end_sale',
                            'convertFormat' => true,
                            'removeButton' => false,
                            'pluginOptions' => [
                                'orientation' => 'bottom',
                                'autoUpdateInput' => false,
                                'format' => 'dd.MM.yyyy',
                                'autoclose' => true,
                                'weekStart' => 1
                            ]
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'format' => 'raw',
                        'value' => function($model) {
                            $datetime = Yii::$app->formatter->asDatetime($model->date_end_sale, 'php:d.m.Y H:i:s');
                            $date = Yii::$app->formatter->asDatetime($model->date_end_sale, 'php:d.m.Y');
                            return "<span title='$datetime'>$date</span>";
                        },
                        'contentOptions' => SettingsWidget::setConfig('date_end_sale', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('date_end_sale', $user_settings['hide-col'], ['title' => 'Дата окончания продаж'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('date_end_sale', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'currency',
                        'label' => 'Вал',
                        'filter' => ['uah' => 'UAH', 'usd' => 'USD', 'eur' => 'EUR'],
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->currency;
                        },
                        'contentOptions' => SettingsWidget::setConfig('currency', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('currency', $user_settings['hide-col'], ['title' => 'Валюта'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('currency', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'old_price',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return number_format($model->old_price, 2, '.', ' ');
                        },
                        'contentOptions' => SettingsWidget::setConfig('old_price', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('old_price', $user_settings['hide-col'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('old_price', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'promo_price',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return number_format($model->promo_price, 2, '.', ' ');
                        },
                        'contentOptions' => SettingsWidget::setConfig('promo_price', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('promo_price', $user_settings['hide-col'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('promo_price', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'sale',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return number_format($model->sale, 2, '.', ' ');
                        },
                        'contentOptions' => SettingsWidget::setConfig('sale', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('sale', $user_settings['hide-col'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('sale', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'price',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return number_format($model->price, 2, '.', ' ');
                        },
                        'contentOptions' => SettingsWidget::setConfig('price', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('price', $user_settings['hide-col'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('price', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'main',
                        'label' => 'Топ прод',
                        'headerOptions' => ['width' => '5%'],
                        'format' => 'raw',
                        'filter' => $main_option,
                        'value' => function($model) use ($main_count) {
                            $option = [];
                            $option[] = '<option value="0">0</option>';
                            for ($i = 1; $i <= $main_count; $i++)
                                $option[] = '<option value="' . $i . '" ' . (($model->main == $i) ? 'selected' : '') . '>' . $i . '</option>';
                            return '<select class="form-control change-position" name="main" data-id="' . $model->id . '">' . implode('', $option) . '</select>';
                        },
                        'contentOptions' => SettingsWidget::setConfig('main', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('main', $user_settings['hide-col'], ['title' => 'Топ продаж'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('main', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'recommend',
                        'label' => '5 океан реком',
                        'headerOptions' => ['width' => '5%'],
                        'format' => 'raw',
                        'filter' => $recommend_option,
                        'value' => function($model) use ($recommend_count) {
                            $option = [];
                            $option[] = '<option value="0">0</option>';
                            for ($i = 1; $i <= $recommend_count; $i++)
                                $option[] = '<option value="' . $i . '" ' . (($model->recommend == $i) ? 'selected' : '') . '>' . $i . '</option>';
                            return '<select class="form-control change-position" name="recommend" data-id="' . $model->id . '">' . implode('', $option) . '</select>';
                        },
                        'contentOptions' => SettingsWidget::setConfig('recommend', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('recommend', $user_settings['hide-col'], ['title' => '5 океан рекомендует'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('recommend', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'hot',
                        'label' => 'Гор туры',
                        'headerOptions' => ['width' => '5%'],
                        'filter' => $hot_option,
                        'format' => 'raw',
                        'value' => function($model) use ($hot_count) {
                            $option = [];
                            $option[] = '<option value="0">0</option>';
                            for ($i = 1; $i <= $hot_count; $i++)
                                $option[] = '<option value="' . $i . '" ' . (($model->hot == $i) ? 'selected' : '') . '>' . $i . '</option>';
                            return '<select class="form-control change-position" name="hot" data-id="' . $model->id . '">' . implode('', $option) . '</select>';
                        },
                        'contentOptions' => SettingsWidget::setConfig('hot', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('hot', $user_settings['hide-col'], ['title' => 'Горящие туры'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('hot', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'exotic_page',
                        'label' => 'Экз(стр)',
                        'headerOptions' => ['width' => '5%'],
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::checkbox('exotic_page', $model->exotic_page, [
                                        'id' => 'exotic_page_' . $model->id,
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => $model->exotic_page,
                                        'data-id' => $model->id,
                                        'data-url' => Url::to(['update-status'])
                                    ]) . Html::label('', 'exotic_page_' . $model->id, ['class' => 'tgl-btn']);
                        },
                        'contentOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'], ['title' => 'Экзотические туры (страница)'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'sale_page',
                        'label' => 'Прод(стр)',
                        'headerOptions' => ['width' => '5%'],
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::checkbox('sale_page', $model->sale_page, [
                                        'id' => 'sale_page_' . $model->id,
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => $model->sale_page,
                                        'data-id' => $model->id,
                                        'data-url' => Url::to(['update-status'])
                                    ]) . Html::label('', 'sale_page_' . $model->id, ['class' => 'tgl-btn']);
                        },
                        'contentOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'], ['title' => 'Топ продаж (страница)'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'hot_page',
                        'label' => 'Гор(стр)',
                        'headerOptions' => ['width' => '5%'],
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::checkbox('hot_page', $model->hot_page, [
                                        'id' => 'hot_page_' . $model->id,
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => $model->hot_page,
                                        'data-id' => $model->id,
                                        'data-url' => Url::to(['update-status'])
                                    ]) . Html::label('', 'hot_page_' . $model->id, ['class' => 'tgl-btn']);
                        },
                        'contentOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'], ['title' => 'Горящие туры (страница)'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'attribute' => 'status',
                        'headerOptions' => ['width' => '5%'],
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::checkbox('status', $model->status, [
                                        'id' => 'status_' . $model->id,
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => $model->status,
                                        'data-id' => $model->id,
                                        'data-url' => Url::to(['update-status'])
                                    ]) . Html::label('', 'status_' . $model->id, ['class' => 'tgl-btn']);
                        },
                        'contentOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null),
                        'headerOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null),
                        'filterOptions' => SettingsWidget::setConfig('status', $user_settings['hide-col'] ?? null, ['width' => '50']),
                    ],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($model, $key, $index, $column) {
                            return ['value' => $model['id']];
                        },
                        'contentOptions' => SettingsWidget::setConfig('delete', $user_settings['hide-col'] ?? null),
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'tour',
                            'count_page' => $page,
                            'hide_col' => $user_settings['hide-col'] ?? null,
                            'attribute' => [
                                'id' => 'ID',
                                'title' => 'Заголовок',
                                'country' => 'Страна',
                                'hotel' => 'Отель',
                                'type_number' => 'Тип номера',
                                'date_departure' => 'Дата отправления',
                                'date_arrival' => 'Дата прибытия',
                                'length' => 'Кол-во ночей',
                                'dept_city_id' => 'Город отправления',
                                'type_transport_id' => 'Тип транспорта',
                                'operator_id' => 'Оператор',
                                'commission' => '% комиссии',
                                'date_begin' => 'Период активности',
                                'date_end_sale' => 'Дата окончания продаж',
                                'currency' => 'Валюта',
                                'old_price' => 'Старая цена',
                                'promo_price' => 'Промо цена',
                                'sale' => 'Скидка (%)',
                                'price' => 'Цена',
                                'main' => 'Топ продаж',
                                'recommend' => '5 океан рекомендует',
                                'hot' => 'Горящие туры'
                            ]
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{update} {delete}',
                        'filter' => '<a href = "' . Url::to(['/referenceBooks/tour'], TRUE) . '"><i class = "grid-option fa fa-filter" title = "Сбросить фильтр"></i></a>',
                        'buttons' => [
                            'update' => function($url, $model, $index) use ($access) {
                                if ($access->accessInView($url)) {
                                    return Html::tag(
                                                    'a', '', [
                                                'href' => $url,
                                                'title' => 'Редактировать',
                                                'aria-label' => 'Редактировать',
                                                'class' => 'grid-option fa fa-pencil',
                                                'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'delete' => function($url, $model, $index) use ($access) {
                                if ($access->accessInView($url)) {
                                    return Html::tag(
                                                    'a', '', [
                                                'href' => $url,
                                                'title' => 'Удалить',
                                                'aria-label' => 'Удалить',
                                                'class' => 'grid-option fa fa-trash',
                                                'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                                'data-method' => 'post',
                                                'data-pjax' => '0'
                                    ]);
                                }
                            }
                        ]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>
