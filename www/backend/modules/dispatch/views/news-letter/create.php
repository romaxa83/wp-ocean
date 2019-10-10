<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\dispatch\forms\NewsLetterForm */

$this->title = 'Создать рассылку';
$this->params['breadcrumbs'][] = ['label' => 'Список рассылок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-letter-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>