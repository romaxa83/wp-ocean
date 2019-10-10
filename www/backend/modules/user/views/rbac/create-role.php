<?php

/* @var $this yii\web\View */
/* @var $form backend\modules\user\forms\rbac\RoleForm */
/* @var $allRoles */

$this->title = 'Создать роль';
$this->params['breadcrumbs'][] = ['label' => 'Роли и разрешения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <?= $this->render('_form-role', [
        'model' => $form,
        'allRoles' => $allRoles,
    ]) ?>

</div>