<?php

use app\modules\dispatch\assets\DispatchAsset;
use backend\modules\blog\components\CustomActionColumn;
use backend\modules\dispatch\entities\NewsLetter;
use backend\modules\dispatch\helpers\Status;
use backend\modules\user\helpers\DateFormat;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\blog\forms\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Информационая рассылка';
$this->params['breadcrumbs'][] = $this->title;

DispatchAsset::register($this);
?>
<div class="news-letter-index">

    <div class="row mb-15">
        <div class="col-xs-6">
            <?php if($access->accessInView(Url::toRoute(['create']))):?>
                <?= Html::a('Создать рассылку', Url::toRoute(['create']), ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $this->title?></h3>
        </div>
        <div class="box-body table-flexible">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-hover'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'subject',
                        'label' => 'Тема письма',
                        'format' => 'raw',
                        'value' => function(NewsLetter $model) use ($access){
                            if($access->accessInView(Url::toRoute(['view']))){
                                return Html::a(Html::encode(StringHelper::truncateWords(strip_tags($model->subject),10)), ['view', 'id' => $model->id]);
                            }
                            return Html::encode(StringHelper::truncateWords(strip_tags($model->subject),10));
                        },
                    ],
                    [
                        'label' => 'Прогресс отправки',
                        'format' => 'raw',
                        'contentOptions' => function(NewsLetter $model){
                            return ['class' => 'progress-cell-'.$model->id];
                        },
                        'value' => function(NewsLetter $model){
                            return $this->render('_progress-bar',['data' => $model->statistic]);
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'contentOptions' => function(NewsLetter $model){
                            return ['class' => 'progress-status-cell-'.$model->id];
                        },
                        'value' => function(NewsLetter $model){
                            return Status::label($model->status);
                        },
                        'filter' => Status::list(),
                        'filterOptions' => [
                            'class' => 'minw-150px'
                        ]
                    ],
                    [
                        'attribute' => 'send',
                        'label' => 'Дата рассылки',
                        'format' => 'raw',
                        'value' => function(NewsLetter $model){
                            return DateFormat::viewTimestamp($model->send);
                        },
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' =>DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'send',
                            'options' => ['placeholder' => 'Дата рассылки'],
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'orientation' => 'bottom',
                                'autoUpdateInput' => false,
                                'format' => 'dd-MM-yyyy',
//                                'format' => 'dd/MM/yyyy',
                                'autoclose'=>true,
                                'weekStart'=>1, //неделя начинается с понедельника
                            ]
                        ]),
                        'filterOptions' => [
                            'class' => 'minw-200px'
                        ]
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header'=>'Управление',
                        'template' => '{update} {delete} {send}',
                        'buttons' => [
                            'update' => function($url, $model, $index) use($access){
                                if($access->accessInView($url)){
                                    if ($model->status == 0){
                                        return Html::tag(
                                            'a',
                                            '',[
                                            'href' => $url,
                                            'title' => 'Редактировать рассылку',
                                            'aria-label' => 'Редактировать рассылку',
                                            'class' => 'grid-option fa fa-pencil',
                                            'data-pjax' => '0'
                                        ]);
                                    }
                                    return '';
                                }
                            },
                            'delete' => function($url, $model, $index) use ($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Удалить рассылку',
                                        'aria-label' => 'Удалить рассылку',
                                        'class' => 'grid-option fa fa-trash',
                                        'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'send' => function($url, $model, $index) use ($access) {
                                if($access->accessInView('dispatch/news-letter/chooseSubscribers')){
                                    if($model->status == 0){
                                        return Html::tag(
                                            'span',
                                            '',[
                                            'title' => 'Запуск рассылки',
                                            'aria-label' => 'Запуск рассылки',
                                            'class' => 'grid-option fa fa-telegram send-letter',
                                            'data-id-letter' => $model->id,
                                            'data-method' => 'post',
                                            'data-pjax' => '0'
                                        ]);
                                    }
                                }
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
