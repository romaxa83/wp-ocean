<?php if (isset($hotel_review[$id]['avg'])) : ?>
    <div class="tour-identification--item tour-identification--review">
        <span>
            <strong><?php echo (isset($hotel_review[$id]['avg'])) ? $hotel_review[$id]['avg'] : 0.0; ?></strong>оценка
        </span>
    </div>
<?php endif; ?>
<?php if (isset($hotel_review[$id]['count'])) : ?>
    <div class="tour-identification--item tour-identification--review review-init">
        <span>
            <strong><?php echo (isset($hotel_review[$id]['count'])) ? $hotel_review[$id]['count'] : 0; ?></strong>отзывов
        </span>
    </div>
<?php endif; ?>
