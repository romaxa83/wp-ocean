<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\widgets\settings\SettingsWidget;
use backend\modules\referenceBooks\models\CustomActionColumn;

/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Справочник операторов';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referenceBooks-dept-city-index">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список операторов</h3>
        </div>
        <div class="box-body table-flexible">
            <?=
            GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table middle',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->id;
                        }
                    ],
                    [
                        'attribute' => 'oid',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->oid;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '75%'],
                        'value' => function($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'attribute' => 'url',
                        'headerOptions' => ['width' => '75%'],
                        'value' => function($model) {
                            return $model->url;
                        }
                    ],
                    [
                        'attribute' => 'currencies',
                        'headerOptions' => ['width' => '75%'],
                        'value' => function($model) {
                            return $model->currencies;
                        }
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
                        'headerOptions' => ['width' => '10%'],
                        'value' => function($model) use ($access) {
                            if ($access->accessInView(Url::to(['update-status']))) {
                                return Html::checkbox('sync', $model->sync, [
                                            'id' => 'sync_' . $model['id'],
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $model->sync,
                                            'data-id' => $model['id'],
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'sync_' . $model['id'], ['class' => 'tgl-btn']);
                            }
                            return StatusHelper::label($model->sync, false, true);
                        },
                        'filterOptions' => [
                            'class' => 'minw-100px'
                        ]
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'operator',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '',
                        'filter' => '<a href = "' . Url::to(['/referenceBooks/operator'], TRUE) . '"><i class = "grid-option fa fa-filter" title = "Сбросить фильтр"></i></a>'
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>
