<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

$this->title = 'SEO данные для поиска';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index">
    <div class="row mb-15">
        <div class="col-md-12">
            <?php echo Html::a('Добавить SEO данные', ['/seoSearch/seo-search/create'], ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список SEO данных</h3>
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
                        'attribute' => 'country_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return (isset($model->country->name)) ? $model->country->name : NULL;
                        }
                    ],
                    [
                        'attribute' => 'dept_city_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return (isset($model->deptCity->name)) ? $model->deptCity->name : NULL;
                        }
                    ],
                    [
                        'attribute' => 'city_id',
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return (isset($model->city->name)) ? $model->city->name : NULL;
                        }
                    ],
                    [
                        'attribute' => 'seo.title',
                        'format' => 'raw',
                        'filter' => '<input type="text" class="form-control" readonly="readonly">',
                        'headerOptions' => ['width' => '70%'],
                        'value' => function($model) {
                            return $model->seo->title;
                        }
                    ],
                    [
                        'attribute' => 'seo.seo_text',
                        'format' => 'raw',
                        'filter' => '<input type="text" class="form-control" readonly="readonly">',
                        'headerOptions' => ['width' => '20%'],
                        'value' => function($model) {
                            return (strlen($model->seo->seo_text) >= 200) ? substr($model->seo->seo_text, 0, strrpos(substr($model->seo->seo_text, 0, 200), ' ')) : $model->seo->seo_text;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'filterOptions' => ['class' => 'minw-100px'],
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return Html::checkbox('status', $model->status, [
                                        'id' => 'status_' . $model['id'],
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => $model->status,
                                        'data-id' => $model['id'],
                                        'data-url' => Url::to(['update-status'])
                                    ]) . Html::label('', 'status_' . $model['id'], ['class' => 'tgl-btn']);
                        }
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'seo_search',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{update}{delete}',
                        'filter' => '<a href="' . Url::to(['/seoSearch/seo-search'], TRUE) . '"><i class="grid-option fa fa-filter" title="Сбросить фильтр"></i></a>'
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>