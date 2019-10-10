<?php
/* @var $group array */
/* @var $currentUrl string */

use backend\modules\menuBuilder\models\MenuItem;
?>

<div class="mobile-menu--section">
    <ul>
        <?php
        foreach ($group['children'] as $item) :
            $data = json_decode($item['data'], true);
            $link = MenuItem::urlBy($item['type'], $data);
            $path = parse_url($link, PHP_URL_PATH);
            ?>
            <?php if ($item['status'] == 1): ?>
                <?php if ($item['type'] == 'link') : ?>
                    <li>
                        <span
                            class="menu-link activated"
                            data-toggle="tooltip"
                            data-html="true"
                            data-container=".mobile-menu--body"
                            data-placement="right"
                            title="<small>В разработке</small>"
                            ><?= $item['title'] ?>
                        </span>
                    </li>
                <?php else : ?>
                    <li>
                        <?php if ($path == $currentUrl) : ?>
                            <span class="menu-link activated"><?= $item['title'] ?></span>
                        <?php else : ?>
                            <a href="<?= $link ?>" class="menu-link activated"><?= $item['title'] ?></a>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
