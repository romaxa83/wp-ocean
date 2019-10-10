<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use app\modules\user\UserAsset;
use backend\modules\user\entities\Reviews;
use backend\modules\user\helpers\DateFormat;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\components\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\forms\search\ReviewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access *
/* @var $user_settings */
/* @var $page */

$this->title = 'Список отзывов';
$this->params['breadcrumbs'][] = $this->title;

UserAsset::register($this);
?>
<div class="reviews-index">

    <div class="box">
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
                        'attribute' => 'id',
                        'label' => 'ID',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return $model->id;
                        },
                        'contentOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col'],['width' => '50px']),
                    ],
                    [
                        'attribute' => 'fullName',
                        'label' => 'Пользователь',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return Html::a($model->user->getFullName(),['/user/view', 'id' => $model->user_id]);
                        },
                        'contentOptions' => SettingsWidget::setConfig('fullName',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('fullName',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('fullName',$user_settings['hide-col']),
                    ],
                    [
                        'attribute' => 'hotel',
                        'label' => 'Отель',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return Html::a($model->hotel->name,['/referenceBooks/hotel/update', 'id' => $model->hotel_id]);
                        },
                        'contentOptions' => SettingsWidget::setConfig('hotel',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('hotel',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('hotel',$user_settings['hide-col']),
                    ],
                    [
                        'attribute' => 'text',
                        'label' => 'Текст',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return $model->text;
                        },
                        'contentOptions' => SettingsWidget::setConfig('text',$user_settings['hide-col'],['style'=>'white-space: normal;']),
                        'headerOptions' => SettingsWidget::setConfig('text',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('text',$user_settings['hide-col']),
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => 'Рейтинг',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return $model->rating;
                        },
                        'filter' => [
                            '1' => 1,
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                            '5' => 5
                        ],
                        'contentOptions' => SettingsWidget::setConfig('rating',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('rating',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('rating',$user_settings['hide-col']),
                    ],
                    [
                        'attribute' => 'from_date',
                        'label' => 'Дата от',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return DateFormat::viewTimestampDate($model->from_date);
                        },
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' =>DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'from_date',
                            'options' => ['placeholder' => 'Дата от'],
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'autoUpdateInput' => false,
                                'format' => 'dd-MM-yyyy',
                                'autoclose'=>true,
                                'weekStart'=>1, //неделя начинается с понедельника
                            ]
                        ]),
                        'contentOptions' => SettingsWidget::setConfig('from_date',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('from_date',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('from_date',$user_settings['hide-col'],['class' => 'minw-200px']),
                    ],
                    [
                        'attribute' => 'to_date',
                        'label' => 'Дата до',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return DateFormat::viewTimestampDate($model->to_date);
                        },
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' =>DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'to_date',
                            'options' => ['placeholder' => 'Дата до'],
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'autoUpdateInput' => false,
                                'format' => 'dd-MM-yyyy',
                                'autoclose'=>true,
                                'weekStart'=>1, //неделя начинается с понедельника
                            ]
                        ]),
                        'contentOptions' => SettingsWidget::setConfig('to_date',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('to_date',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('to_date',$user_settings['hide-col'],['class' => 'minw-200px']),
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Создан',
                        'format' => 'raw',
                        'value' => function(Reviews $model){
                            return DateFormat::viewTimestampDate($model->created_at);
                        },
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' =>DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'created_at',
                            'options' => ['placeholder' => 'Создание'],
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'autoUpdateInput' => false,
                                'format' => 'dd-MM-yyyy',
                                'autoclose'=>true,
                                'weekStart'=>1, //неделя начинается с понедельника
                            ]
                        ]),
                        'contentOptions' => SettingsWidget::setConfig('created_at',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('created_at',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('created_at',$user_settings['hide-col'],['class' => 'minw-200px']),
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Опубликовать',
                        'format' => 'raw',
                        'value' => function(Reviews $model) use ($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/user/reviews/status-change');
                            }
                            return StatusHelper::label($model->status);
                        },
                        'filter' => [
                            '0' => 'Выкл.',
                            '1' => 'Вкл.'
                        ],
                        'contentOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']),
                        'headerOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']),
                        'filterOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']),
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'reviews',
                            'count_page' => $page,
                            'hide_col' => $user_settings['hide-col'],
                            'attribute' => [
                                'id' => 'ID',
                                'fullName' => 'Пользователь',
                                'hotel' => 'Отель',
                                'text' => 'Текст',
                                'rating' => 'Рейтинг',
                                'from_date' => 'Дата от',
                                'to_date' => 'Дата до',
                                'created_at' => 'Создан',
                                'status' => 'Опубликовать',
                            ]
                        ]),
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function($url, $model, $index) use($access){
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Редактировать отзыв',
                                        'aria-label' => 'Редактировать отзыв',
                                        'class' => 'grid-option fa fa-pencil',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'delete' => function($url, $model, $index) use($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Удалить отзыв',
                                        'aria-label' => 'Удалить отзыв',
                                        'class' => 'grid-option fa fa-trash',
                                        'data-confirm' => 'Вы уверены, что хотите удалить этот отзыв?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
