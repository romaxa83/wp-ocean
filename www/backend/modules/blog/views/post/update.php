<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\blog\forms\PostForm */
/* @var $post backend\modules\blog\entities\Post */

$this->title ='Редактировать пост';
$this->params['breadcrumbs'][] = ['label' => 'Список постов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$options = [];
if($post->status == 1){
    $options = ['readonly' => true];
}
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
        'post' => $post,
        'options' => $options
    ]) ?>

</div>
