<?php

/* @var $data backend\modules\staticBlocks\entities\Block */
?>
<?php if($data):?>
    <section class="section section-counter">
        <div class="counter">
            <div class="container p-0">
				<div class="swiper-container counter-container">
					<div class="swiper-wrapper flex-sm-wrap">
						<?php foreach ($data as $one):?>
							<div class="swiper-slide col-xs-12 col-sm-6 col-md-6 col-lg-3 counter-col">
								<div class="counter-col--header" data-num="<?= $one->title?>">0</div>
								<?= $one->description?>
							</div>
						<?php endforeach;?>
                	</div>
				</div>
            </div>
        </div>
    </section>
<?php endif;?>