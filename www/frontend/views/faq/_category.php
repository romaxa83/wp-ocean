<?php

use backend\modules\faq\helpers\IconHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $categories backend\modules\faq\repository\FaqCategoryRepository*/
/** @var $categoryActive*/
?>

<aside class="col-sm-12 col-md-12 col-lg-4 col-xl-3 blog-left pt-0">
    <div class="blog-left--menu d-flex flex-wrap">
        <?php foreach ($categories as $category):?>
            <div class="blog-left-menu__item with-obj <?=$categoryActive == $category->alias?'active':'';?>">
                <span class="d-flex align-items-center justify-content-center">
                    <img src="<?= IconHelper::iconUrl($category->icon,true)?>" alt="alt">
                </span>
                <?= Html::button($category->name,[
                    'class' => 'show-any-faq',
                    'data-route' => Url::toRoute(['/faq/category/'.$category->alias,'#' => 'faqBody'])
                ])?>
            </div>
        <?php endforeach;?>
    </div>
</aside>
