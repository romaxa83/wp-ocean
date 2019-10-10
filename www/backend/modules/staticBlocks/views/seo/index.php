<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\blog\helpers\StatusHelper;
use app\modules\staticBlocks\StaticBlocksAsset;
use backend\modules\staticBlocks\entities\Block;
use backend\modules\staticBlocks\helpers\BlocksHelper;
use backend\modules\blog\components\CustomActionColumn;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $blocks */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Блок: "Seo"';
$this->params['breadcrumbs'][] = $this->title;

StaticBlocksAsset::register($this);
?>
<div class="seo-index">

    <p>
        <?php if($access->accessInView('staticBlocks/static-blocks/toggle-block')):?>
            <?= (new BlocksHelper($blocks))->btnToggleBlock('seo')?>
        <?php endif;?>
        <?php if($access->accessInView(Url::toRoute(['create']))):?>
            <?= Html::a('Создать seo', Url::toRoute(['create']), ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
    </p>

    <div class="box">
        <div class="box-body table-flexible">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'alias',
                        'label' => 'Алиас',
                        'format' => 'raw',
                        'value' => function (Block $model) {
                            return $model->alias;
                        },
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Заголовок',
                        'format' => 'raw',
                        'value' => function (Block $model) {
                            return Html::encode($model->title);
                        },
                    ],
                    [
                        'attribute' => 'description',
                        'label' => 'Текст',
                        'format' => 'raw',
                        'value' => function (Block $model) {
                            return StringHelper::truncateWords($model->description,10);
                        },
                    ],
                    [
                        'attribute' => 'position',
                        'label' => 'Позиция',
                        'format' => 'raw',
                        'value' => function (Block $model) {
                            return $model->position;
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function(Block $model) use($access){
                            if($access->accessInView('staticBlocks/static-blocks/toggle-status')){
                                return (new BlocksHelper())->checkToggleSection($model);
                            }
                            return StatusHelper::label($model->status);
                        },
                        'filter' => StatusHelper::list()
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header'=>'Управление',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function($url, $model, $index) use($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Редактировать данные',
                                        'aria-label' => 'Редактировать данные',
                                        'class' => 'grid-option fa fa-pencil',
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
