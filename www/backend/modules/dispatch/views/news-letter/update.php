<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\dispatch\forms\NewsLetterForm */

$this->title = 'Редактировать рассылку';
$this->params['breadcrumbs'][] = ['label' => 'Список рассылок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-letter-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>