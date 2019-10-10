<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\dispatch\helpers\DateHelper;

/* @var $model backend\modules\dispatch\entities\NewsLetter */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Информационая рассылка - "' . $model->subject . '."';
$this->params['breadcrumbs'][] = ['label' => 'Письма', 'url' => Url::toRoute(['index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letter-view">
    <div class="row mb-15">
        <div class="col-xs-6">
            <?php if($access->accessInView(Url::toRoute(['update']))):?>
                <?= Html::a('Редактировать', Url::toRoute(['update','id' => $model->id]), ['class' => 'btn btn-primary mr-15']) ?>
            <?php endif;?>

            <?= Html::a('Вернуться', Url::toRoute(['index']), ['class' => 'btn btn-primary mr-15']) ?>
        </div>
    </div>
    <?php if(isset($model->statistic) && $model->statistic->end_time !== null):?>
        <div class="box">
            <div class="box-header with-border">Информация о рассылки</div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model->statistic,
                    'attributes' => [
                        [
                            'label' => 'Рассылка стартовала',
                            'value' => (new DateHelper())->formatTimestamp($model->statistic->start_time),
                        ],
                        [
                            'label' => 'Рассылка закончилась',
                            'value' => (new DateHelper())->formatTimestamp($model->statistic->end_time),
                        ],
                        [
                            'label' => 'Время потраченное на рассылку',
                            'value' => (new DateHelper())->diffTimestamp($model->statistic->end_time,$model->statistic->start_time)
                        ],
                        [
                            'label' => 'Отослано писем',
                            'value' => '('.$model->statistic->sended .'/'. $model->statistic->all . ')'
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif;?>
    <div class="box">
        <?= $this->render('@common/mail/layouts/html',[
            'model' => $model,
        ]);?>
    </div>
</div>