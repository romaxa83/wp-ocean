<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\faq\models\Faq */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Список Faq', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-create">

    <?= $this->render('_form', [
        'model' => $model,
        'access' => $access
    ]) ?>

</div>