<?php
/* @var $group array */
/* @var $currentUrl string */

use backend\modules\menuBuilder\models\MenuItem;
use backend\modules\menuBuilder\widgets\menuRenderGroup\MenuRenderGroupWidget;
?>

<li class="footer-list__item">
    <ul class="social-icons d-flex justify-content-start align-items-center">
        <?php foreach ($group['children'] as $item) : ?>
            <?php if ($item['status'] == 1): ?>
                <li class="social-icons__item">
                    <?php
                    $data = json_decode($item['data'], true);
                    $link = MenuItem::urlBy($item['type'], $data);
                    ?>
                    <a target="_blank" href="<?= $link ?>" class="social-icons__link" rel="nofollow">
                        <i class="social-icons__icon icon <?= $data['icon']; ?>"></i>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</li>