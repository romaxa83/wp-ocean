<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\helpers\StringHelper;
use app\modules\blog\BlogAsset;
use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\entities\HotelReview;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\components\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\blog\forms\search\HotelReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user_settings */
/* @var $page */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Список обзоров на отели';
$this->params['breadcrumbs'][] = $this->title;

BlogAsset::register($this);
?>
<div class="blog-hotel-review-index">

    <div class="row mb-15">
        <div class="col-xs-6">
            <?php if($access->accessInView(Url::toRoute(['create']))):?>
                <?= Html::a('Создать обзор', Url::toRoute(['create']), ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Список обзоров</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div style="overflow-x: scroll;">
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
                                    'value' => function(HotelReview $model){
                                        return $model->id;
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null,['width' => '50']),
                                ],
                                [
                                    'attribute' => 'title',
                                    'label' => 'Название',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model) use($access){
                                        if($access->accessInView(Url::toRoute(['view']))){
                                            return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                                        }
                                        return Html::encode($model->title);
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('title',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('title',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('title',$user_settings['hide-col']??null),
                                ],
                                [
                                    'attribute' => 'alias',
                                    'label' => 'Алиас',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model){
                                        return $model->alias;
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('alias',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('alias',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('alias',$user_settings['hide-col']??null),
                                ],
                                [
                                    'attribute' => 'hotel_id',
                                    'label' => 'Отель',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model) use ($access){
                                        if($access->accessInView('/referenceBooks/hotel/update')){
                                            return Html::a($model->hotel->name,['/referenceBooks/hotel/update', 'id' => $model->hotel_id]);
                                        }
                                        return $model->hotel->name;
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('hotel_id',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('hotel_id',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('hotel_id',$user_settings['hide-col']??null),
                                ],
                                [
                                    'attribute' => 'description',
                                    'label' => 'Описание',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model){
                                        return StringHelper::truncateWords(strip_tags($model->description),10);
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('description',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('description',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('description',$user_settings['hide-col']??null,['width' => '100px']),
                                ],
                                [
                                    'attribute' => 'views',
                                    'label' => 'Просмотров',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model){
                                        return $model->views;
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('views',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('views',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('views',$user_settings['hide-col']??null),
                                ],
                                [
                                    'attribute' => 'likes',
                                    'label' => 'Лайков',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model){
                                        return $model->likes;
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('likes',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('likes',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('likes',$user_settings['hide-col']??null),
                                ],
                                [
                                    'attribute' => 'links',
                                    'label' => 'Ссылки',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model){
                                        return $model->links;
                                    },
                                    'contentOptions' => SettingsWidget::setConfig('links',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('links',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('links',$user_settings['hide-col']??null),
                                ],
                                [
                                    'label' => 'Публикация',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model){
                                        return DateHelper::postStatus($model);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'language' => 'ru',
                                        'type' =>DatePicker::TYPE_COMPONENT_APPEND,
                                        'attribute' => 'created_at',
                                        'options' => ['placeholder' => 'Дата создания'],
                                        'convertFormat' => true,
                                        'pluginOptions' => [
                                            'orientation' => 'bottom',
                                            'autoUpdateInput' => false,
                                            'format' => 'dd-MM-yyyy',
                                            'autoclose'=>true,
                                            'weekStart'=>1, //неделя начинается с понедельника
                                        ]
                                    ]),
                                    'contentOptions' => SettingsWidget::setConfig('published',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('published',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('published',$user_settings['hide-col']??null),
                                ],
                                [
                                    'attribute' => 'status',
                                    'label' => 'Статус',
                                    'format' => 'raw',
                                    'value' => function(HotelReview $model) use ($access){
                                        if($access->accessInView(Url::toRoute(['status-change']))){
                                            return StatusHelper::checkBox($model,'/blog/hotel-review/status-change');
                                        }
                                        return StatusHelper::label($model->status,true);
                                    },
                                    'filter' => StatusHelper::listPost(),
                                    'contentOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null),
                                    'headerOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null),
                                    'filterOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null,['class' => 'minw-160px']),
                                ],
                                [
                                    'class' => CustomActionColumn::className(),
                                    'header' => SettingsWidget::widget([
                                        'model' => 'post_hotel_review',
                                        'count_page' => $page,
                                        'hide_col' => $user_settings['hide-col']??null,
                                        'attribute' => [
                                            'id' => 'ID',
                                            'title' => 'Название',
                                            'alias' => 'Алиас',
                                            'hotel_id' => 'Отель',
                                            'description' => 'Описание',
                                            'views' => 'Просмотры',
                                            'likes' => 'Лайки',
                                            'links' => 'Ссылки',
                                            'published' => 'Публикация',
                                            'status' => 'Статус',
                                        ]
                                    ]),
                                    'template' => '{update} {delete}',
                                    'buttons' => [
                                        'update' => function($url, $model, $index) use($access) {
                                            if($access->accessInView($url)){
                                                return Html::tag(
                                                    'a',
                                                    '',[
                                                    'href' => $url,
                                                    'title' => 'Редактировать обзор',
                                                    'aria-label' => 'Редактировать обзор',
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
                                                    'title' => 'Удалить обзор',
                                                    'aria-label' => 'Удалить обзор',
                                                    'class' => 'grid-option fa fa-trash',
                                                    'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
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
        </div>
    </div>
</div>
