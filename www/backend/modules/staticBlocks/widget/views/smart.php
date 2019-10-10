<?php

/* @var $data backend\modules\staticBlocks\entities\Block */

?>
<?php if($data):?>
    <section class="section section-smart">
        <div class="container">
            <div class="section-header header-text-left" id="line-3">
                <div class="row">
                    <div class=" col-12 header-title" id="animate3">
                        <span class="header-title__text">Подключите</span>
                        <h2 class="header-title__title">Smart рассылку на туры</h2>
						<h3 class="header-title__subTitle">эффективное индивидуальное информирование по заданным параметрам</h3>
                    </div>
                </div>
            </div>

            <div class="steps-wrapper">
                <h5 class="steps-header offset-md-1 col-12 col-md-11 ">
                    Как это работает:
                </h5>
                <div class="row">
                    <div class="col-12 col-md-11 offset-md-1">
                        <div class="row steps">
                        <?php foreach ($data as $one):?>
                            <div class="col-12 col-md-6 col-lg-4 step">
                                <div class="step__counter">
                                    <svg viewBox="0 0 36 36" class="circular-chart orange">
                                        <path class="circle-bg" d="M18 2.0845
														a 15.9155 15.9155 0 0 1 0 31.831
														a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="circle" stroke-dasharray="<?= $one->title?>" d="M18 2.0845
														a 15.9155 15.9155 0 0 1 0 31.831
														a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    </svg>
                                    <span><?= $one->position ?></span>
                                </div>
                                <div class="step__description">
                                    <?= $one->description ?>
                                </div>
                            </div>
                        <?php endforeach;?>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn-regular btn-size-m button-isi">Smart-рассылка</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif;?>