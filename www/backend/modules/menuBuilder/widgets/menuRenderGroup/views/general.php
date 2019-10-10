<?php

use backend\modules\menuBuilder\models\MenuItem;

/* @var $group array */
/* @var $currentUrl string */
?>

<div class="mobile-menu--section">
    <ul>
        <?php foreach ($group['children'] as $item) : ?>
            <?php if ($item['status'] == 1): ?>
                <li>
                    <?php
                    $data = json_decode($item['data'], true);
                    $link = MenuItem::urlBy($item['type'], $data);
                    $path = parse_url($link, PHP_URL_PATH);
                    ?>
                    <?php if ($path == $currentUrl) : ?>
                        <span class="menu-link activated"><?= $item['title'] ?></span>
                    <?php else : ?>
                        <a href="<?= $link ?>" class="menu-link activated"><?= $item['title'] ?></a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
