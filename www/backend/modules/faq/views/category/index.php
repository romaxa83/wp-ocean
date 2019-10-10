<?php

use backend\modules\faq\helpers\IconHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\faq\FaqAsset;
use backend\modules\faq\models\Category;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\components\CustomActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\faq\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Список категорий для F.A.Q.';
$this->params['breadcrumbs'][] = $this->title;

FaqAsset::register($this);
?>
<div class="faq-category-index">

    <div class="row mb-15">
        <div class="col-xs-6">
            <?php if($access->accessInView(Url::toRoute(['create']))):?>
                <?= Html::a('Создать категорию', Url::toRoute(['create']), ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Список категорий для F.A.Q.</h3>
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
                        'value' => function(Category $model){
                            return $model->id;
                        }
                    ],
                    [
                        'attribute' => 'media_id',
                        'format' => 'raw',
                        'value' => function(Category $model){
                            return Html::img( IconHelper::iconUrl($model->icon),['style' => 'width:70px;background:rgb(238,238,238',]);
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function(Category $model){
                            return Html::encode($model->name);
                        }
                    ],
                    [
                        'attribute' => 'alias',
                        'format' => 'raw',
                        'value' => function(Category $model){
                            return Html::encode($model->alias);
                        }
                    ],
                    [
                        'attribute' => 'position',
                        'format' => 'raw',
                        'value' => function(Category $model){
                            return Html::encode($model->position);
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function(Category $model) use($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/faq/category/status-change');
                            }
                            return StatusHelper::label($model->status);
                        },
                        'filterOptions' => ['class' => 'minw-100px'],
                        'filter' => StatusHelper::list(true)
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'template' => '{update} {delete} {move-down} {move-up}',
                        'buttons' => [
                            'update' => function($url, $model, $index) use ($access) {
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
                            'delete' => function($url, $model, $index) use ($access) {
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
                            'move-up' => function($url, $model, $index) use ($access){
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Переместить категорию вверх',
                                        'aria-label' => 'Переместить категорию вверх',
                                        'class' => 'grid-option fa fa-arrow-up',
                                        'data-method' => 'post',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'move-down' => function($url, $model, $index) use ($access){
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Переместить категорию вниз',
                                        'aria-label' => 'Переместить категорию вниз',
                                        'class' => 'grid-option fa fa-arrow-down',
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
