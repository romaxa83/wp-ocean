<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\user\forms\UserForm */
/* @var $user common\models\User */

$this->title = 'Редактирование пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'user' => $user,
        'model' => $model,
    ]) ?>

</div>