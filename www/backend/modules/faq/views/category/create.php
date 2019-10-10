<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\faq\models\Category */

$this->title = 'Создать категорию';
$this->params['breadcrumbs'][] = ['label' => 'Список категорий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>