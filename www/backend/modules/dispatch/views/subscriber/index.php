<?php

use backend\modules\blog\components\CustomActionColumn;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\dispatch\entities\Subscriber;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\dispatch\assets\DispatchAsset;
use backend\modules\dispatch\entities\Notifications;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Подписчики на информационую рассылку';
$this->params['breadcrumbs'][] = $this->title;

DispatchAsset::register($this);
?>
<div class="subscriber-index">
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
                        'attribute' => 'email',
                        'label' => 'Email',
                        'format' => 'raw',
                        'value' => function(Subscriber $model){
                            return $model->email;
                        },
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'Имя',
                        'format' => 'raw',
                        'value' => function(Subscriber $model) use($access){
                            if ($model->user_id){
                                if($access->accessInView('/user/user/view')){
                                    return Html::a( $model->user->getFullName(), ['/user/user/view', 'id' => $model->user_id]);
                                }
                                return $model->user->getFullName();
                            }
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function(Subscriber $model) use ($access){
                            if($access->accessInView('/dispatch/subscriber/status-change')){
                                return StatusHelper::checkBox($model,'/dispatch/subscriber/status-change');
                            }
                            return StatusHelper::label($model->status);
                        },
                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header'=>'Управление',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function($url, $model, $index) use($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Удалить подписчика',
                                        'aria-label' => 'Удалить подписчика',
                                        'class' => 'grid-option fa fa-trash',
                                        'data-confirm' => 'Вы уверены, что хотите удалить этого подписчика?',
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
