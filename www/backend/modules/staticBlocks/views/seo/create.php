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
/* @var $last_position */

$this->title ='Создание секции для блока "SEO"';
$this->params['breadcrumbs'][] = ['label' => 'Список секций', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="seo-create">

    <?= $this->render('_form', [
        'model' => $model,
        'last_position' => $last_position,
    ]) ?>

</div>
