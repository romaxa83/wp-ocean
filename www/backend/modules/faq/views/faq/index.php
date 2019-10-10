<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\faq\FaqAsset;
use yii\helpers\StringHelper;
use backend\modules\faq\models\Faq;
use backend\modules\faq\helpers\WrapHelper;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\components\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\faq\models\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $page */
/* @var $user_settings */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Список Faq';
$this->params['breadcrumbs'][] = $this->title;

FaqAsset::register($this);
?>
<div class="faq-index">

    <div class="row mb-15">
        <div class="col-xs-6">
            <?php if($access->accessInView(Url::toRoute(['create']))):?>
                <?= Html::a('Создать запись', Url::toRoute(['create']), ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Список воросов и ответов</h3>
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
                        'attribute' => 'id',
                        'label' => 'ID',
                        'format' => 'raw',
                        'value' => function(Faq $model){
                            return $model->id;
                        },
                        'contentOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'question',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView(Url::toRoute(['view']))){
                                return Html::a(Html::encode(StringHelper::truncateWords(strip_tags($model->question),3)), ['view', 'id' => $model->id]);
                            }
                            return Html::encode(StringHelper::truncateWords(strip_tags($model->question),3));
                        },
                        'contentOptions' => SettingsWidget::setConfig('question',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('question',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('question',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'answer',
                        'format' => 'raw',
                        'value' => function(Faq $model){
                            return StringHelper::truncateWords(strip_tags($model->answer),3);
                        },
                        'contentOptions' => SettingsWidget::setConfig('answer',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('answer',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('answer',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'category_id',
                        'label' => 'Категория',
                        'format' => 'raw',
                        'value' => function(Faq $model){
                            if(isset($model->category->name)){
                                return $model->category->name;
                            }
                        },
                        'contentOptions' => SettingsWidget::setConfig('category_id',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('category_id',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('category_id',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'page_faq',
                        'label' => 'FAQ',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/faq/faq/status-change?alias=page_faq','page_faq');
                            }
                            return StatusHelper::label($model->page_faq);
                        },
                        'filter' => StatusHelper::list(true),
                        'contentOptions' => SettingsWidget::setConfig('page_faq',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('page_faq',$user_settings['hide-col']??null,['width' => '10px']),
                        'filterOptions' => SettingsWidget::setConfig('page_faq',$user_settings['hide-col']??null,['class' => 'minw-100px']),
                    ],
                    [
                        'attribute' => 'rate_faq',
                        'label' => 'R.FAQ',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView('faq/faq/change-rate')){
                                return WrapHelper::input($model->rate_faq,'faq',$model->id);
                            }
                            return WrapHelper::wrap($model->rate_faq);
                        },
                        'contentOptions' => SettingsWidget::setConfig('rate_faq',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('rate_faq',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('rate_faq',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'page_vip',
                        'label' => 'Vip',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView(Url::toRoute('status-change'))){
                                return StatusHelper::checkBox($model,'/faq/faq/status-change?alias=page_vip','page_vip');
                            }
                            return StatusHelper::label($model->page_vip);
                        },
                        'filter' => StatusHelper::list(true),
                        'contentOptions' => SettingsWidget::setConfig('page_vip',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('page_vip',$user_settings['hide-col']??null,['width' => '4%']),
                        'filterOptions' => SettingsWidget::setConfig('page_vip',$user_settings['hide-col']??null,['class' => 'minw-100px']),
                    ],
                    [
                        'attribute' => 'rate_vip',
                        'label' => 'R.Vip',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView('faq/faq/change-rate')){
                                return WrapHelper::input($model->rate_vip,'vip',$model->id);
                            }
                            return WrapHelper::wrap($model->rate_vip);
                        },
                        'contentOptions' => SettingsWidget::setConfig('rate_vip',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('rate_vip',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('rate_vip',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'page_exo',
                        'label' => 'Exotic',
                        'format' => 'raw',
                        'value' => function(Faq $model) use($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/faq/faq/status-change?alias=page_exo','page_exo');
                            }
                            return StatusHelper::label($model->page_exo);
                        },
                        'filter' => StatusHelper::list(true),
                        'contentOptions' => SettingsWidget::setConfig('page_exo',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('page_exo',$user_settings['hide-col']??null,['width' => '4%']),
                        'filterOptions' => SettingsWidget::setConfig('page_exo',$user_settings['hide-col']??null,['class' => 'minw-100px']),
                    ],
                    [
                        'attribute' => 'rate_exo',
                        'label' => 'R.Exotic',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView('faq/faq/change-rate')){
                                return WrapHelper::input($model->rate_exo,'exo',$model->id);
                            }
                            return WrapHelper::wrap($model->rate_exo);
                        },
                        'contentOptions' => SettingsWidget::setConfig('rate_exo',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('rate_exo',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('rate_exo',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'page_hot',
                        'label' => 'Hot',
                        'format' => 'raw',
                        'value' => function(Faq $model) use($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/faq/faq/status-change?alias=page_hot','page_hot');
                            }
                            return StatusHelper::label($model->page_hot);
                        },
                        'filter' => StatusHelper::list(true),
                        'contentOptions' => SettingsWidget::setConfig('page_hot',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('page_hot',$user_settings['hide-col']??null,['width' => '4%']),
                        'filterOptions' => SettingsWidget::setConfig('page_hot',$user_settings['hide-col']??null,['class' => 'minw-100px']),
                    ],
                    [
                        'attribute' => 'rate_hot',
                        'label' => 'R.Hot',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView('faq/faq/change-rate')){
                                return WrapHelper::input($model->rate_hot,'hot',$model->id);
                            }
                            return WrapHelper::wrap($model->rate_hot);
                        },
                        'contentOptions' => SettingsWidget::setConfig('rate_hot',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('rate_hot',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('rate_hot',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function(Faq $model) use ($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/faq/faq/status-change');
                            }
                            return StatusHelper::label($model->status);
                        },
                        'filter' => StatusHelper::list(true),
                        'contentOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null,['width' => '4%']),
                        'filterOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null,['class' => 'minw-100px']),
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'faq',
                            'count_page' => $page,
                            'hide_col' => $user_settings['hide-col']??null,
                            'attribute' => [
                                'id' => 'ID',
                                'question' => 'Вопрос',
                                'answer' => 'Ответ',
                                'category_id' => 'Категори',
                                'page_faq' => 'Стр. FAQ',
                                'rate_faq' => 'Рейтинг на FAQ',
                                'page_vip' => 'Стр. VIP',
                                'rate_vip' => 'Рейтинг на FAQ',
                                'page_exo' => 'Стр.Exotic',
                                'rate_exo' => 'Рейтинг на Exotic',
                                'page_hot' => 'Стр. Hot',
                                'rate_hot' => 'Рейтинг на Hot',
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
                                        'title' => 'Редактировать запись',
                                        'aria-label' => 'Редактировать запись',
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
                                        'title' => 'Удалить запись',
                                        'aria-label' => 'Удалить запись',
                                        'class' => 'grid-option fa fa-trash',
                                        'data-confirm' => 'Вы уверены, что хотите удалить эту запись?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
