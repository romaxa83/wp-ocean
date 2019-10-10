<?php
/* @var $data backend\modules\staticBlocks\entities\Block */

use yii\helpers\StringHelper;
use yii\helpers\Url;
?>
<?php if ($data):?>
    <?php $path = '/admin' . Url::base();?>
    <?php $first = true;?>
    <?php $small_block = true;?>
<section class="section section-about">
	<div class="about">
		<div class="container">
			<div class="section-header header-text-left" id="line-6">
				<div class="row">
					<div class="offset-1 col-11 header-title" id="animate6">
						<span class="header-title__text">информация</span>
						<div class="header-title__title">о компании</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-6 about-col swiper-container">
					<div class="swiper-wrapper">
                        <?php foreach($data as $one):?>
                            <?php if($one->alias == 'video' && !empty($one->title) && !empty($one->description)):?>
                                <?php if($first):?>
						            <div class="swiper-slide">
							            <div class="about-video big-block swiper-slide"
                                             data-link="<?= $path . $one->video->url?>"
                                             style="background: url(<?= $path . $one->preview->url?>) center / cover no-repeat">
                                            <img src="img/play-icon-cut.png" alt="icon-play" />
							            </div>
						            </div>
                                    <?php $first = false;?>
                                <?php else:?>
                                    <div class="swiper-slide visible-991">
                                        <div class="about-video big-block swiper-slide"
                                             data-link="<?= $path . $one->video->url?>"
                                             style="background: url(<?= $path . $one->preview->url?>) center / cover no-repeat">
                                            <img src="img/play-icon-cut.png" alt="icon-play" />
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endif;?>
                        <?php endforeach;?>
					</div>
				</div>
				<div class="col-xs-12 col-md-12 col-lg-6">
					<div class="row">
                        <?php foreach($data as $one):?>
                            <?php if($one->alias == 'video' && !empty($one->title) && !empty($one->description)):?>
                                <?php if($small_block):?>
                                    <?php $small_block = false;?>
                                <?php else:?>
                                    <div class="col-md-6 hidden-991">
                                        <div class="about-video small-block"
                                             data-link="<?= $path . $one->video->url?>"
                                             style="background: url(<?= $path . $one->preview->url?>) center / cover no-repeat">
                                            <img src="img/play-icon-cut.png" alt="icon-play" />
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php else:?>
                                <div class="col-md-12 col-info-animate">
                                    <div class="about--desc">
                                        <?= StringHelper::truncateWords($one->description,100)?>
                                    </div>
                                    <a href="<?php echo Url::to(['team/index', 'template' => 'about-us'], true); ?>" class="btn-regular btn-size-m button-isi">подробнее</a>
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modal-video">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body position-relative">
                    <div class="modal-header-absolute">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
					<video id="video" class="w-100" controls="">
					</video>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;?>