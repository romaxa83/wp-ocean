<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Reviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reviews-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <div id="reviews-block" class="col-xs-12 col-md-6 col-reviews">
    <?= \backend\modules\user\widgets\reviews\ReviewsWidget::widget([
        'template' => 'reviews',
        'user_id' => Yii::$app->user->identity->id,
        'hotel_id' => 22
    ])?>
    </div>
</div>