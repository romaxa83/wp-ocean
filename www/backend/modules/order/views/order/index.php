<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список заказов</h3>
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
                            'attribute' => 'hotel_id',
                            'headerOptions' => ['width' => '10%'],
                            'value' => function($model) {
                                return $model->hotel_id;
                            }
                        ],
                        [
                            'attribute' => 'date',
                            'filter' => '<input type="text" class="form-control" readonly="readonly">',
                            'headerOptions' => ['width' => '10%'],
                            'value' => function($model) {
                                return Yii::$app->formatter->asDate($model->date, 'php: d.m.Y H:i:s');
                            }
                        ],
                        [
                            'attribute' => 'offer',
                            'headerOptions' => ['width' => '10%'],
                            'value' => function($model) {
                                return $model->offer;
                            }
                        ],
                        [
                            'attribute' => 'name',
                            'headerOptions' => ['width' => '10%'],
                            'value' => function($model) {
                                return $model->name;
                            }
                        ],
                        [
                            'attribute' => 'email',
                            'headerOptions' => ['width' => '10%'],
                            'value' => function($model) {
                                return $model->email;
                            }
                        ],
                        [
                            'attribute' => 'phone',
                            'headerOptions' => ['width' => '10%'],
                            'value' => function($model) {
                                return $model->phone;
                            }
                        ],
                        [
                            'attribute' => 'comment',
                            'filter' => '<input type="text" class="form-control" readonly="readonly">',
                            'headerOptions' => ['width' => '20%'],
                            'value' => function($model) {
                                return $model->comment;
                            }
                        ],
                        [
                            'attribute' => 'price',
                            'filter' => '<input type="text" class="form-control" readonly="readonly">',
                            'headerOptions' => ['width' => '5%'],
                            'value' => function($model) {
                                return number_format($model->price, 2, '.', ' ') . ' ₴';
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'filter' => Yii::$app->params['status_order'],
                            'headerOptions' => ['width' => '5%'],
                            'value' => function($model) {
                                return Yii::$app->params['status_order'][$model->status];
                            },
                            'filterOptions' => [
                                'class' => 'minw-150px'
                            ]
                        ],
                        [
                            'class' => CustomActionColumn::className(),
                            'header' => SettingsWidget::widget([
                                'model' => 'order',
                                'count_page' => $page,
                                'hide_col_status' => false,
                            ]),
                            'headerOptions' => ['width' => '10%'],
                            'template' => '{close} {delete} {info}',
                            'filter' => '<a href="' . Url::to(['/order/order'], TRUE) . '"><i class="grid-option fa fa-filter" title="Сбросить фильтр"></i></a>',
                            'buttons' => [
                                'close' => function ($url, $model) use ($access){
                                    if($access->accessInView($url)){
                                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-ok"></span>', (new yii\grid\ActionColumn())->createUrl('order/close', $model, $model['id'], 1), [
                                            'title' => 'Выполнен'
                                        ]);
                                    }
                                },
                                'delete' => function($url, $model, $index) use ($access) {
                                    if($access->accessInView($url)){
                                        return Html::tag(
                                            'a',
                                            '<span class="glyphicon glyphicon-trash"></span>',[
                                            'href' => $url,
                                            'title' => 'Удалить заказ',
                                            'aria-label' => 'Удалить заказ',
                                            'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                            'data-method' => 'post',
                                            'data-pjax' => '0'
                                        ]);
                                    }
                                },
                                'info' => function ($url,$model) use ($access){
                                    if($access->accessInView($url)){
                                        return Html::tag('span',
                                            '<span class="glyphicon glyphicon-info-sign"></span>', [
                                                'class' => 'more-info-order',
                                                'data-url' => $url,
                                                'data-id' => $model['id'],
                                                'style' => 'cursor:pointer',
                                                'title' => 'Детальная информация о туре'
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
