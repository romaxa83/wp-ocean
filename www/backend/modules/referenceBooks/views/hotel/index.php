<?php

use backend\modules\blog\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Справочник отелей';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referenceBooks-hotel-index">
    <div class="row">
        <div class="col-md-12 mb-15">
            <?php if ($access->accessInView('/referenceBooks/hotel/create')): ?>
                <?= Html::a('Добавить отель', ['/referenceBooks/hotel/create'], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список отелей</h3>
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
                        'attribute' => 'hid',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->hid;
                        }
                    ],
                    [
                        'attribute' => 'media_id',
                        'filter' => '<input type="text" class="form-control" disabled="disabled">',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return ($model->media !== NULL) ? '<img src="' . Url::base(TRUE) . '/' . $model->media->url . '" height="50px" width="85px" />' : NULL;
                        }
                    ],
                    [
                        'attribute' => 'country_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->countries['name'];
                        }
                    ],
                    [
                        'attribute' => 'city_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->cites['name'];
                        }
                    ],
                    [
                        'attribute' => 'category_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->category_id;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '50%'],
                        'value' => function($model) {
                            return $model->name;
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
                            return StatusHelper::label($model->sync, false, true);
                        },
                        'filterOptions' => [
                            'class' => 'minw-100px'
                        ]
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'hotel',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{update} {delete}',
                        'filter' => '<a href = "' . Url::to(['/referenceBooks/hotel'], TRUE) . '"><i class = "grid-option fa fa-filter" title = "Сбросить фильтр"></i></a>',
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
