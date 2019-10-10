<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\blog\BlogAsset;
use backend\modules\blog\entities\Tag;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\components\CustomActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\blog\forms\search\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Теги для статей';
$this->params['breadcrumbs'][] = $this->title;

BlogAsset::register($this);
?>
<div class="tag-index">

    <p>
        <?php if($access->accessInView(Url::toRoute(['create']))):?>
            <?= Html::a('Создать тег', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
    </p>
    <div class="box">
        <div class="box-body table-flexible">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id',
                        'label' => 'ID',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '50'],
                        'value' => function(Tag $model){
                            return $model->id;
                        }
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Название',
                        'format' => 'raw',
                        'value' => function (Tag $model) use($access) {
                            if($access->accessInView(Url::toRoute(['view']))){
                                return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                            }
                            return Html::encode($model->title);
                        },
                    ],
                    [
                        'attribute' => 'alias',
                        'label' => 'Алиас',
                        'format' => 'raw',
                        'value' => function (Tag $model) {
                            return $model->alias;
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function(Tag $model) use ($access){
                            if($access->accessInView(Url::toRoute(['status-change']))){
                                return StatusHelper::checkBox($model,'/blog/tag/status-change');
                            }
                            return StatusHelper::label($model->status);
                        },
                        'filter' => StatusHelper::list()
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header'=>'Управление',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function($url, $model, $index) use($access){
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Редактировать статью',
                                        'aria-label' => 'Редактировать статью',
                                        'class' => 'grid-option fa fa-pencil',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'delete' => function($url, $model, $index) use($access){
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Удалить статью',
                                        'aria-label' => 'Удалить статью',
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
