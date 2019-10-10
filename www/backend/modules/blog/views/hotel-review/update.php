<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\blog\forms\HotelReviewForm */

$this->title = 'Редактировать обзор на отель';
$this->params['breadcrumbs'][] = ['label' => 'Список обзоров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-hotel-review-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>