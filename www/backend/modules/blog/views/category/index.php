<?php

use backend\modules\blog\components\CustomActionColumn;
use backend\modules\blog\helpers\StatusHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\blog\BlogAsset;
use backend\modules\blog\entities\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\blog\forms\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Категории для постов';
$this->params['breadcrumbs'][] = $this->title;

BlogAsset::register($this);
?>
<div class="category-post-index">

    <div class="row mb-15">
        <div class="col-xs-6">
            <?php if ($access->accessInView(Url::toRoute(['create']))):?>
                <?= Html::a('Создать категорию', Url::toRoute(['create']), ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Список категорий</h3>
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
                        'headerOptions' => ['width' => '50'],
                        'value' => function(Category $model){
                            return $model->id;
                        }
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Название',
                        'format' => 'raw',
                        'value' => function(Category $model) use ($access){
                            $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                            if($access->accessInView(Url::toRoute(['view']))){
                                return $indent . Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                            }
                            return $indent . Html::encode($model->title);
                        }
                    ],
                    [
                        'attribute' => 'alias',
                        'label' => 'Алиас',
                        'format' => 'raw',
                        'value' => function(Category $model){
                            return $model->alias;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function(Category $model) use ($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/blog/category/status-change');
                            }
                            return StatusHelper::label($model->status);
                        },
                        'filter' => StatusHelper::list()
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header'=>'Управление',
                        'template' => '{update} {delete} {move-up} {move-down}',
                        'buttons' => [
                            'update' => function($url, $model, $index) use ($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Редактировать категорию',
                                        'aria-label' => 'Редактировать категорию',
                                        'class' => 'grid-option fa fa-pencil',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'delete' => function($url, $model, $index) use ($access){
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Удалить категорию',
                                        'aria-label' => 'Удалить категорию',
                                        'class' => 'grid-option fa fa-trash',
                                        'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
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
