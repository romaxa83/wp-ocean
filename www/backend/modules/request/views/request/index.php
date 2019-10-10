<?php

use backend\modules\request\helpers\TypeHelper;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список заявок</h3>
        </div>
        <div class="box-body table-flexible">
            <?php
            echo GridView::widget([
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
                        }
                    ],
                    [
                        'attribute' => 'date',
                        'filter' => '<input type="text" class="form-control" readonly="readonly">',
                        'headerOptions' => ['width' => '14%'],
                        'value' => function($model) {
                            return Yii::$app->formatter->asDate($model->date, 'php: d.m.Y H:i:s');
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '14%'],
                        'value' => function($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'attribute' => 'email',
                        'headerOptions' => ['width' => '14%'],
                        'value' => function($model) {
                            return $model->email;
                        }
                    ],
                    [
                        'attribute' => 'phone',
                        'headerOptions' => ['width' => '14%'],
                        'value' => function($model) {
                            return $model->phone;
                        }
                    ],
                    [
                        'attribute' => 'comment',
                        'filter' => '<input type="text" class="form-control" readonly="readonly">',
                        'headerOptions' => ['width' => '30%'],
                        'value' => function($model) {
                            return $model->comment;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => Yii::$app->params['status_order'],
                        'headerOptions' => ['width' => '14%'],
                        'value' => function($model) {
                            return Yii::$app->params['status_order'][$model->status];
                        },
                        'filterOptions' => [
                            'class' => 'minw-150px'
                        ]
                    ],
                    [
                        'attribute' => 'type',
                        'format' => 'raw',
                        'filter' => TypeHelper::getTypes(),
                        'headerOptions' => ['width' => '10%'],
                        'value' => function($model) {
                            return TypeHelper::prettyType($model->type);
                        },
                        'filterOptions' => [
                            'class' => 'minw-150px'
                        ]
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'request',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{close}{delete}',
                        'filter' => '<a href="' . Url::to(['/request/request'], TRUE) . '"><i class="grid-option fa fa-filter" title="Сбросить фильтр"></i></a>',
                        'buttons' => [
                            'close' => function ($url, $model) use ($access) {
                                if ($access->accessInView($url)) {
                                    return \yii\helpers\Html::a('<span class="fa fa-check"></span>', (new yii\grid\ActionColumn())->createUrl('request/close', $model, $model['id'], 1), [
                                                'title' => 'Выполнен'
                                    ]);
                                }
                            },
                            'delete' => function($url, $model, $index) use ($access) {
                                if ($access->accessInView($url)) {
                                    return Html::tag(
                                                    'a', '', [
                                                'href' => $url,
                                                'title' => 'Удалить статью',
                                                'aria-label' => 'Удалить статью',
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
