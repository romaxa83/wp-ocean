<?php

use yii\helpers\Url;

/** @var $title*/
/** @var $referrer*/
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                <li class="breadcrumb-item"
                    itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= Url::toRoute('site/index',true) ?>">
                        <span itemprop="name">Главная</span>
                    </a>
                    <meta itemprop="position" content="1" />
                </li>
                <?php if ($title):?>
                <li class="breadcrumb-item"
                    itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="<?= Url::toRoute('/blog',true) ?>">
                        <span itemprop="name">Блог</span>
                    </a>
                    <meta itemprop="position" content="2" />
                </li>
                    <?php if($referrer):?>
                        <li class="breadcrumb-item"
                            itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="<?= Url::toRoute($referrer['url'],true) ?>">
                                <span itemprop="name"><?= $referrer['title']?></span>
                            </a>
                            <meta itemprop="position" content="3" />
                        </li>
                    <?php endif;?>

                    <li class="breadcrumb-item active" aria-current="page">
                        <span><?= $title ?></span>
                    </li>

                <?php else:?>
                <li class="breadcrumb-item active" aria-current="page">
                    <span>Блог</span>
                </li>
                <?php endif;?>
            </ol>
        </div>
    </div>
</div>