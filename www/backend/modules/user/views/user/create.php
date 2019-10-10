<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\user\forms\UserForm */

$this->title = 'Создать пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>