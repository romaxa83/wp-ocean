<?php

use backend\modules\blog\entities\Category;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\blog\BlogAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\staticBlocks\forms\SeoForm*/
/* @var $form yii\widgets\ActiveForm */
/* @var $count_position */

$this->title ='Редактирование секции для блока "SEO"';
$this->params['breadcrumbs'][] = ['label' => 'Список секций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="seo-update">

    <?= $this->render('_form', [
        'model' => $model,
        'count_position' => $count_position
    ]) ?>

</div>
