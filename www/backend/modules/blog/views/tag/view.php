<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\blog\helpers\StatusHelper;

/* @var $this yii\web\View */
/* @var $tag backend\modules\blog\entities\Tag */
/* @var $access backend\modules\user\useCase\Access */

$this->title = $tag->title;
$this->params['breadcrumbs'][] = ['label' => 'Список тегов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-view">

    <p>
        <?php if($access->accessInView(Url::toRoute(['update']))):?>
            <?= Html::a('Редактирование', ['update', 'id' => $tag->id], ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
        <?= Html::a('Вернуться', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?php if($access->accessInView(Url::toRoute(['delete']))):?>
            <?= Html::a('Удаление', ['delete', 'id' => $tag->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены что хотите удалить этот тег?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $tag,
                        'attributes' => [
                            'id',
                            'title',
                            'alias',
                            [
                                'attribute' => 'status',
                                'label' => 'Статус',
                                'format' => 'raw',
                                'value' => StatusHelper::label($tag->status),
                            ]
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>

