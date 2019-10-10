<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;
use backend\models\Settings;

$this->title = 'Фильтр';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index">
    <div class="row mb-15">
        <div class="col-md-12">
            <?php echo Html::a('Добавить фильтр', ['/filter/filter/create'], ['class' => 'btn btn-primary']); ?>
            <div class="pull-right" style="padding-top: 4px;">
                <?php
                $promo_price = Settings::find()->where(['name' => 'promo_price'])->asArray()->one()['body'];
                echo Html::checkbox('promo_price', $promo_price, [
                    'id' => 'promo_price',
                    'class' => 'tgl tgl-light custome-checkbox',
                    'value' => $promo_price,
                    'data-url' => Url::to(['update-promo-price'])
                ]) . Html::label('', 'promo_price', ['class' => 'tgl-btn', 'title' => 'Отображать туры с Promo Price']);
                ?>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Список фильтров</h3>
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
                        'attribute' => 'alias',
                        'headerOptions' => ['width' => '32%'],
                        'value' => function($model) {
                            return $model->alias;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'headerOptions' => ['width' => '32%'],
                        'value' => function($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'attribute' => 'link',
                        'headerOptions' => ['width' => '40%'],
                        'value' => function($model) {
                            return $model->link;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                        'headerOptions' => ['width' => '5%'],
                        'value' => function($model) {
                            return Html::checkbox('status', $model->status, [
                                        'id' => 'status_' . $model['id'],
                                        'class' => 'tgl tgl-light custome-checkbox',
                                        'value' => $model->status,
                                        'data-id' => $model['id'],
                                        'data-url' => Url::to(['update-status'])
                                    ]) . Html::label('', 'status_' . $model['id'], ['class' => 'tgl-btn']);
                        },
                        'filterOptions' => [
                            'class' => 'minw-100px'
                        ]
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'filter',
                            'count_page' => $page,
                            'hide_col_status' => false,
                        ]),
                        'headerOptions' => ['width' => '5%'],
                        'template' => '{update}{delete}',
                        'filter' => '<a href="' . Url::to(['/filter/filter'], TRUE) . '"><i class="grid-option fa fa-filter" title="Сбросить фильтр"></i></a>'
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>
</div>