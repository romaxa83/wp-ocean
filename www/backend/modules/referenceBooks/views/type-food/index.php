<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\widgets\settings\SettingsWidget;
use backend\modules\referenceBooks\models\CustomActionColumn;

/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Справочник типы питания';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referenceBooks-type-food-index">
    <div class="row">
        <div class="col-md-12 mb-15">
            <?php if ($access->accessInView('/referenceBooks/type-food/create')): ?>
                <?= Html::a('Добавить тип питания', ['/referenceBooks/type-food/create'], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список типы питания</h3>
        </div>
        <div class="box-body table-flexible">
            <?=
            GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'id' => 'sortable',
                    'class' => 'table middle',
                    'data-url' => Url::toRoute(['update-position'], TRUE)
                ],
                'rowOptions' => function($model) {
                    return ['id' => 'item-' . $model->id];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'code',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return $model->code;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '70%'],
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
                            'model' => 'type_food',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'filter' => '<a href = "' . Url::to(['/referenceBooks/type-food'], TRUE) . '"><i class = "grid-option fa fa-filter" title = "Сбросить фильтр"></i></a>',
                        'template' => '{update} {delete}',
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
                        ],
                    ],
                    [
                        'header' => '<i class="fa fa-arrows-alt" title="Drag & Drop"></i>',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '1%'],
                        'value' => function() {
                            return '<i class="fa fa-arrows-alt"></i>';
                        }
                    ],
                ]
            ]);
            ?>
        </div>
    </div>
</div>
