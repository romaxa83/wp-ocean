<?php

use backend\modules\blog\components\CustomActionColumn;
use backend\modules\blog\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\dispatch\assets\DispatchAsset;
use backend\modules\dispatch\entities\Notifications;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Список шаблонов';
$this->params['breadcrumbs'][] = $this->title;

DispatchAsset::register($this);
?>
<div class="notifications-index">
    <?php if($access->accessInView(Url::toRoute(['upload-pattern']))):?>
        <?= Html::a('Загрузить шаблоны',
            Url::toRoute(['upload-pattern']),
            [
                'class' => 'btn btn-primary',
                'data-method' => 'POST',
                'data-params' => [
                    'status' => 'upload'
                ]
            ])?>
    <?php endif;?>
    <?php if($access->accessInView(Url::toRoute(['pattern-delete']))):?>
        <?= Html::a('Сбросить шаблоны',
            Url::toRoute(['pattern-delete']),
            [
                'class' => 'btn btn-danger',
                'data-method' => 'POST',
                'data-params' => [
                    'status' => 'pattern-delete'
                ]
            ])?>
    <?php endif;?>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $this->title?></h3>
        </div>
        <div class="box-body table-flexible">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-hover'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'label' => 'Имя шаблона',
                        'format' => 'raw',
                        'value' => function(Notifications $model){
                            return $model->name;
                        },
                    ],
                    [
                        'attribute' => 'alias',
                        'label' => 'Alias',
                        'format' => 'raw',
                        'value' => function(Notifications $model){
                            return $model->alias;
                        },
                    ],
                    [
                        'attribute' => 'text',
                        'label' => 'Текст',
                        'format' => 'raw',
                        'value' => function(Notifications $model){
                            return $model->text;
                        },
                    ],
                    [
                        'attribute' => 'variables',
                        'label' => 'Доступные переменные',
                        'format' => 'raw',
                        'value' => function(Notifications $model){
                            return $model->variables;
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function(Notifications $model) use ($access){
                            if($access->accessInView('/dispatch/notifications/status-change')){
                                return StatusHelper::checkBox($model,'/dispatch/notifications/status-change');
                            }
                            return StatusHelper::label($model->status);
                        },
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
                                        'title' => 'Редактировать шаблон',
                                        'aria-label' => 'Редактировать шаблон',
                                        'class' => 'grid-option fa fa-pencil',
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
