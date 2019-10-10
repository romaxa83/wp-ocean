<?php

use backend\modules\blog\entities\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\blog\helpers\StatusHelper;

/* @var $this yii\web\View */
/* @var $faq backend\modules\faq\models\Faq */
/* @var $access backend\modules\user\useCase\Access */

$this->title = strip_tags($faq->question);
$this->params['breadcrumbs'][] = ['label' => 'Список Faq', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-view">

    <p>
        <?php if($access->accessInView(Url::toRoute(['update']))):?>
            <?= Html::a('Редактирование', ['update', 'id' => $faq->id], ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
        <?= Html::a('Вернуться', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?php if($access->accessInView(Url::toRoute(['delete']))):?>
            <?= Html::a('Удаление', ['delete', 'id' => $faq->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены что хотите удалить эту категорию?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;?>
    </p>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">Вопрос</div>
                        <div class="box-body">
                            <p><?=$faq->question?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">Вопрос</div>
                        <div class="box-body">
                            <p><?=$faq->answer?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $faq,
                        'attributes' => [
                            [
                                'attribute' => 'category_id',
                                'format' => 'raw',
                                'value' => $faq->category->name,
                            ],
                            [
                                'attribute' => 'page_faq',
                                'format' => 'raw',
                                'value' => StatusHelper::label($faq->page_faq),
                            ],
                            [
                                'attribute' => 'rate_faq',
                                'format' => 'raw',
                                'value' => $faq->rate_faq,
                            ],
                            [
                                'attribute' => 'page_vip',
                                'format' => 'raw',
                                'value' => StatusHelper::label($faq->page_vip),
                            ],
                            [
                                'attribute' => 'rate_vip',
                                'format' => 'raw',
                                'value' => $faq->rate_vip,
                            ],
                            [
                                'attribute' => 'page_exo',
                                'format' => 'raw',
                                'value' => StatusHelper::label($faq->page_exo),
                            ],
                            [
                                'attribute' => 'rate_exo',
                                'format' => 'raw',
                                'value' => $faq->rate_exo,
                            ],
                            [
                                'attribute' => 'page_hot',
                                'format' => 'raw',
                                'value' => StatusHelper::label($faq->page_hot),
                            ],
                            [
                                'attribute' => 'rate_hot',
                                'format' => 'raw',
                                'value' => $faq->rate_hot,
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Статус',
                                'format' => 'raw',
                                'value' => StatusHelper::label($faq->status),
                            ],
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>