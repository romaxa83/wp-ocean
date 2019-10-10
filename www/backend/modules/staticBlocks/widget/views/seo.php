<?php
/* @var $data backend\modules\staticBlocks\entities\Block */
?>
<?php if($data):?>
    <?php $first_seo = true;?>
    <section class="section section-seo grey-bg">
        <div class="container invisible">
            <div class="seo-wrapper" id="collapseExample">
                <h1><?= ($data[0])->title?></h1>
                <?php
                    preg_match("/<.*>(.*)<\/.*>/",($data[0])->description,$text);
                    echo current($text);
                ?>
                <?php foreach($data as $one):?>
                    <?php if($first_seo):?>
                        <?php echo str_replace(current($text),' ',$one->description) ?>
                        <?php $first_seo = false;?>
                    <?php else:?>
                        <h2><?= $one->title?></h2>
                        <?= $one->description?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </section>
<?php endif;?>
