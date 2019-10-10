<?php

use backend\modules\blog\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Справочник городов';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referenceBooks-city-index">
    <div class="row mb-15">
        <div class="col-md-12">
            <?php if ($access->accessInView('/referenceBooks/city/create')): ?>
                <?php echo Html::a('Добавить город', ['/referenceBooks/city/create'], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Список городов</h3>
        </div>
        <div class="box-body table-flexible">
            <?php
            echo GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-hover'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'country_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return (isset($model->country->name)) ? $model->country->name : NULL;
                        }
                    ],
                    [
                        'attribute' => 'code',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->code;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '79%'],
                        'value' => function($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'attribute' => 'capital',
                        'format' => 'raw',
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) use ($access) {
                            if ($access->accessInView(Url::to(['update-status']))) {
                                return Html::checkbox('capital', $model->capital, [
                                            'id' => 'capital_' . $model['id'],
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $model->capital,
                                            'data-id' => $model['id'],
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'capital_' . $model['id'], ['class' => 'tgl-btn']);
                            }

                            return StatusHelper::label($model->capital, false, true);
                        },
                        'filterOptions' => [
                            'class' => 'minw-100px'
                        ]
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) use ($access) {
                            if ($access->accessInView(Url::to(['update-status']))) {
                                return Html::checkbox('status', $model->status, [
                                            'id' => 'status_' . $model['id'],
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $model->status,
                                            'data-id' => $model['id'],
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'status_' . $model['id'], ['class' => 'tgl-btn']);
                            }
                            return StatusHelper::label($model->status, false, true);
                        },
                        'filterOptions' => [
                            'class' => 'minw-100px'
                        ]
                    ],
                    [
                        'attribute' => 'sync',
                        'format' => 'raw',
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) use($access) {
                            if ($access->accessInView(Url::to(['update-status']))) {
                                return Html::checkbox('sync', $model->sync, [
                                            'id' => 'sync_' . $model['id'],
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $model->sync,
                                            'data-id' => $model['id'],
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'sync_' . $model['id'], ['class' => 'tgl-btn']);
                            }
                        }
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'city',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{update} {delete}',
                        'filter' => '<a href="' . Url::to(['/referenceBooks/city'], TRUE) . '"><i class="grid-option fa fa-filter" title="Сбросить фильтр"></i></a>',
                        'buttons' => [
                            'update' => function($url, $model, $index) use ($access) {
                                if ($access->accessInView($url)) {
                                    return Html::tag(
                                                    'a', '', [
                                                'href' => $url,
                                                'title' => $url,
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
