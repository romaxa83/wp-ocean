<?php
/* @var $group array */

use backend\modules\menuBuilder\models\MenuItem;
?>

<div class="footer-links-wrapper">
    <div class="footer-links-list__title">
        <?= $group['title'] ?>
    </div>
    <ul class="footer-list">
        <?php foreach ($group['children'] as $item) : ?>
            <?php if ($item['status'] == 1): ?>
                <?php
                $data = json_decode($item['data'], true);
                $link = MenuItem::urlBy($item['type'], $data);
                $path = parse_url($link, PHP_URL_PATH);
                ?>
                <?php if ($item['type'] == 'link') : ?>
                    <li class="footer-list__item">
                        <span
                            class="footer-list__link"
                            data-toggle="tooltip"
                            data-html="true"
                            data-placement="bottom"
                            title="<small>В разработке</small>"
                            ><?= $item['title'] ?>
                        </span>
                    </li>
                <?php else : ?>
                    <li class="footer-list__item">
                        <?php if ($path == $currentUrl) : ?>
                            <span class="footer-list__link"><?= $item['title'] ?></span>
                        <?php else : ?>
                            <a href="<?= $link ?>" class="footer-list__link"><?= $item['title'] ?></a>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>