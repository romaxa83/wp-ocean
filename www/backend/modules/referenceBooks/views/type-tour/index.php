<?php

use backend\modules\blog\helpers\StatusHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\blog\helpers\ImageHelper;
use backend\modules\referenceBooks\models\TypeTour;
use backend\modules\blog\widgets\settings\SettingsWidget;
use backend\modules\referenceBooks\models\CustomActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\referenceBooks\models\TypeTourSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user_settings */
/* @var $page */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Справочник типов туров';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referenceBooks-type-tour-index">
    <div class="row">
        <div class="col-md-12 mb-15">
            <?php if ($access->accessInView(Url::toRoute(['create']))): ?>
                <?= Html::a('Добавить тип тура', ['create'], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список типов отелей</h3>
        </div>
        <div class="box-body table-flexible">
            <?=
            GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'media_id',
                        'format' => 'raw',
                        'value' => function (TypeTour $model) {
                            return ($model->media_id !== null) ? ImageHelper::renderImg($model->media->thumbs, 'small') : ImageHelper::notImg();
                        }
                    ],
                    [
                        'attribute' => 'code',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function(TypeTour $model) {
                            return $model->code;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '79%'],
                        'value' => function(TypeTour $model) {
                            return $model->name;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'headerOptions' => ['width' => '5%'],
                        'value' => function(TypeTour $model) use ($access) {
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
                        'value' => function(TypeTour $model) use ($access) {
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
                            'model' => 'type-tour',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{update} {delete}',
                        'filter' => '<a href="' . Url::to(['/referenceBooks/type-tour'], TRUE) . '"><i class="grid-option fa fa-filter" title="Сбросить фильтр"></i></a>',
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
