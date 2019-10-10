<?php

use backend\modules\menuBuilder\models\MenuItem;

/* @var $group array */
/* @var $currentUrl string */
?>

<div class="mobile-menu--section">
    <ul>
        <li>
            <?php
            $data = json_decode($group['data'], true);
            $link = MenuItem::urlBy($group['type'], $data);
            $path = parse_url($link, PHP_URL_PATH);
            ?>
            <?php if($path == $currentUrl) : ?>
                <span class="menu-link activated"><?= $group['title'] ?></span>
            <?php else : ?>
                <a href="<?= $link ?>" class="menu-link activated"><?= $group['title'] ?></a>
            <?php endif; ?>
        </li>
    </ul>
</div>