<?php

use backend\modules\staticBlocks\helpers\Grid;

/* @var $data backend\modules\staticBlocks\entities\Block */
?>
<?php if($data):?>
    <section class="section section-advantages">
        <div class="advantages">
            <div class="container">
                <div class="section-header header-text-right header-text_white" id="line-4">
                    <div class="row">
                        <div class="offset-md-4 offset-lg-6 col-12 col-md-8 col-lg-6 header-title" id="animate4">
                            <span class="header-title__text">Наши</span>
                            <div class="header-title__title">Преимущества</div>
                        </div>
                    </div>
                </div>
                <div class="row">

                <?php foreach ($data as $one):?>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-<?= Grid::set($data)?> advantages-col">
                        <div class="advantages-col--icon">
                            <span><?= $one->title?></span>
                        </div>
                        <div class="advantages-col--desc"><?= $one->description?></div>
                    </div>
                <?php endforeach;?>

                </div>
            </div>
        </div>
    </section>
<?php endif;?>