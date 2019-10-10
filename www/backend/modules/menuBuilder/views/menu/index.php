<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Создание меню</h3>
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-5">
            <?= $form->field($model, 'name')
                ->textInput([
                    'maxlength' => true,
                    'placeholder' => $model->getAttributeLabel('name')
                ])
                ->label(false);
            ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'label')
                ->textInput([
                    'maxlength' => true,
                    'placeholder' => $model->getAttributeLabel('label')
                ])
                ->label(false);
            ?>
        </div>
        <div class="col-md-1">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Список меню</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'label',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=>'Действия',
                        'headerOptions' => ['width' => '80'],
                        'buttons' => [
                            'edit' => function($url, $model) {
                                return Html::a(
                                    '<i class="fa fa-fw fa-list"></i>',
                                    ['/menuBuilder/menu-item', 'menuId' => $model->id],
                                    [
                                        'title' => 'Редактировать меню',
                                        'data-pjax' => '0',
                                    ]
                                );
                            }
                        ],
                        'template' => '{edit} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php
if(Yii::$app->session->hasFlash('errors')) {
    Yii::$app->session->getFlash('errors');
}
if(Yii::$app->session->hasFlash('success')) {
    Yii::$app->session->getFlash('success');
}