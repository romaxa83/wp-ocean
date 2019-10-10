<?php

use backend\modules\blog\helpers\StatusHelper;
use backend\modules\user\useCase\Access;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\specials\models\Special;
use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Список акций';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="specials-special-index">
        <div class="row mb-15">
            <div class="col-md-12">
                <?php if($access->accessInView('/specials/specials/create')):?>
                    <?php echo Html::a('Добавить акцию', ['/specials/specials/create'], ['class' => 'btn btn-primary']); ?>
                <?php endif;?>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Список акций</h3>
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
                            'attribute' => 'name',
                            'headerOptions' => ['width' => '50%'],
                            'value' => function($model) {
                                return $model->name;
                            }
                        ],
                        [
                            'attribute' => 'from_datetime',
                            'format' => 'raw',
                            'value' => function(Special $model){
                                return $model->from_datetime;
                            },
//                            'filter' => DatePicker::widget([
//                                'model' => $searchModel,
//                                'language' => 'ru',
//                                'type' =>DatePicker::TYPE_COMPONENT_APPEND,
//                                'attribute' => 'from_datetime',
//                                'options' => ['placeholder' => 'Дата начала'],
//                                'convertFormat' => true,
//                                'pluginOptions' => [
//                                    'autoUpdateInput' => false,
//                                    'format' => 'yyyy-MM-dd',
//                                    'autoclose'=>true,
//                                    'weekStart'=>1, //неделя начинается с понедельника
//                                ]
//                            ]),
                        ],
                        [
                            'attribute' => 'to_datetime',
                            'format' => 'raw',
                            'value' => function(Special $model){
                                return $model->to_datetime;
                            },
//                            'filter' => DatePicker::widget([
//                                'model' => $searchModel,
//                                'language' => 'ru',
//                                'type' =>DatePicker::TYPE_COMPONENT_APPEND,
//                                'attribute' => 'to_datetime',
//                                'options' => ['placeholder' => 'Дата окончания'],
//                                'convertFormat' => true,
//                                'pluginOptions' => [
//                                    'autoUpdateInput' => false,
//                                    'format' => 'yyyy-MM-dd',
//                                    'autoclose'=>true,
//                                    'weekStart'=>1, //неделя начинается с понедельника
//                                ]
//                            ]),
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'filterOptions' => ['class' => 'minw-100px'],
                            'filter' => [1 => 'Вкл', 0 => 'Выкл'],
                            'headerOptions' => ['width' => '8%'],
                            'value' => function($model) use ($access) {
                                if($access->accessInView(Url::to(['update-status']))){
                                    return Html::checkbox('status', $model->status, [
                                            'id' => 'status_' . $model['id'],
                                            'class' => 'tgl tgl-light custome-checkbox',
                                            'value' => $model->status,
                                            'data-id' => $model['id'],
                                            'data-url' => Url::to(['update-status'])
                                        ]) . Html::label('', 'status_' . $model['id'], ['class' => 'tgl-btn']);
                                }
                                return StatusHelper::label($model->status,false,true);
                            }
                        ],

                        [
                            'class' => CustomActionColumn::className(),
                            'header' => SettingsWidget::widget([
                                'model' => 'special',
                                'count_page' => $page,
                                'hide_col_status' => false,
                            ]),
                            'headerOptions' => ['width' => '5%'],
                            'template' => '{update} {delete}',
                            'filter' => '<a href="' . Url::to(['/specials/specials'], TRUE) . '"><i class="grid-option fa fa-filter" title="Сбросить фильтр"></i></a>',
                            'buttons' => [
                                'update' => function($url, $model, $index) use ($access) {
                                    if($access->accessInView($url)){
                                        return Html::tag(
                                            'a',
                                            '',[
                                            'href' => $url,
                                            'title' => $url,
                                            'aria-label' => 'Редактировать',
                                            'class' => 'grid-option fa fa-pencil',
                                            'data-pjax' => '0'
                                        ]);
                                    }
                                },
                                'delete' => function($url, $model, $index) use ($access) {
                                    if($access->accessInView($url)){
                                        return Html::tag(
                                            'a',
                                            '',[
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
<?php
