<?php if (isset($reviews) && count($reviews) > 0): ?>
    <?php foreach ($reviews as $v): ?>
        <div class="tour-testimonials d-flex">
            <div class="tour-testimonials--avatar">
                <img src="<?php echo $v['avatar']; ?>" alt="alt" width="71">
                <h6 class="tour-testimonials--name font-size-xs"><?php echo $v['user']; ?></h6>
            </div>
            <div class="tour-testimonials--desc">
                <div class="testimonials-desc--top d-flex align-items-baseline justify-content-between">
                    <div class="reviews-rating">
                        <div class="d-flex align-items-center">
                            <div class="reviews-rating__total mr-3"><?php echo 'Оценка ' . number_format($v['vote'], 1, '.', '') ?></div>
                            <div class="reviews-rating__pill-wrapper d-flex mx-0 mr-md-3">
                                <?php for ($i = 10; $i > 0; $i--): ?>
                                    <input type="radio" name="<?php echo 'rating_' . $v['id']; ?>" value="<?php echo $i; ?>" disabled <?php echo (floor($v['vote']) == $i) ? 'checked="true"' : ''; ?> >
                                    <label for="<?php echo 'star-' . $i; ?>" class="mb-0">
                                        <i class="reviews-rating__pill" aria-hidden="true"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="testimonials--date color-6e6e6e font-size-xs font-weight-normal">
                        <span><?php echo Yii::$app->formatter->asDate($v['date'], 'php:d.m.Y'); ?></span>
                    </div>
                </div>
                <div class="testimonials-desc--middle">
                    <h2><?php echo $v['title']; ?></h2>
                    <p class="font-size-xs color-979797 truncate-v2"><?php echo $v['comment']; ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    Нет данных
<?php endif; ?>