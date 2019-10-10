<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Passport Form';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="passport-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= \backend\modules\user\widgets\user\UserWidget::widget(['template' => 'passport'])?>
</div>
