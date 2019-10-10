<?php

/* @var $form_passport backend\modules\user\forms\PassportForm */
/* @var $form_user backend\modules\user\forms\UserForm */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="cabinet-settings">

    <?= \backend\modules\user\widgets\user\UserWidget::widget([
        'template' => 'set-avatar',
        'user_id' => Yii::$app->user->identity->id
    ])?>

    <?= \backend\modules\user\widgets\user\UserWidget::widget([
        'template' => 'phone-email',
        'form' => $form_user
    ])?>

    <?= \backend\modules\user\widgets\user\UserWidget::widget([
        'template' => 'change-password',
        'user_id' => Yii::$app->user->identity->id
    ])?>

    <?= \backend\modules\user\widgets\user\UserWidget::widget([
        'template' => 'passport',
        'form' => $form_passport
    ])?>
</div>