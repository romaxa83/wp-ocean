<?php

use yii\helpers\Html;

$this->title = 'Кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet">
    <?= \backend\modules\user\widgets\smartMailing\SmartMailingWidget::widget([
        'template' => 'form'
    ])?>

    <?= \backend\modules\user\widgets\smartMailing\SmartMailingWidget::widget([
        'template' => 'all-smart-subscription',
        'user_id' => \Yii::$app->user->id
    ])?>

    <h3>Подписка на новости</h3>
    <?= Html::checkbox(
            'dispatch',
            \Yii::$app->user->identity->getDispatch(),[
                'class' => 'check-dispatch',
                'data-user-id' => \Yii::$app->user->id
    ])?>
</div>