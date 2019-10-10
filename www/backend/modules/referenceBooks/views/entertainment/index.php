<?php

use backend\modules\blog\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Справочник развлечений';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referenceBooks-country-index">
    <div class="row mb-15">
        <div class="col-md-12">
            <?php if ($access->accessInView('/referenceBooks/entertainment/create')): ?>
                <?= Html::a('Добавить развлечение', ['/referenceBooks/entertainment/create'], ['class' => 'btn btn-primary']); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список развлечений</h3>
        </div>
        <div class="box-body table-flexible">
            <?=
            GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table middle'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'media_id',
                        'format' => 'raw',
                        'filter' => '<input type="text" class="form-control" readonly="readonly">',
                        'headerOptions' => ['width' => '6%'],
                        'contentOptions' => ['class' => 'media'],
                        'value' => function($model) {
                            $media = unserialize($model->media->thumbs);
                            return '<img src="' . Url::to(Url::base() . $media['small'], true) . '"/>';
                        }
                    ],
                    [
                        'attribute' => 'country_id',
                        'headerOptions' => ['width' => '6%'],
                        'value' => function($model) {
                            return $model->country->name;
                        }
                    ],
                    [
                        'attribute' => 'city_id',
                        'headerOptions' => ['width' => '6%'],
                        'value' => function($model) {
                            return $model->city->name;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '77%'],
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
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'entertainment',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{update} {delete}',
                        'filter' => '<a href = "' . Url::to(['/referenceBooks/entertainment'], TRUE) . '"><i class = "grid-option fa fa-filter" title = "Сбросить фильтр"></i></a>',
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
