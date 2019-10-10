<?php
/* @var $group array */
/* @var $currentUrl string */

use backend\modules\menuBuilder\models\MenuItem;
use backend\modules\menuBuilder\widgets\menuRenderGroup\MenuRenderGroupWidget;
?>

<div class="footer-links-wrapper">
    <div class="footer-links-list__title">
        <?= $group['title'] ?>
    </div>
    <ul class="footer-list">
        <?php foreach ($group['children'] as $item) : ?>
            <?php if ($item['status'] == 1): ?>
                <?php $data = json_decode($item['data'], true); ?>
                <?php if ($item['type'] == 'group') : ?>
                    <?=
                    MenuRenderGroupWidget::widget([
                        'template' => $data['template'],
                        'group' => $item
                    ]);
                    ?>
                <?php else : ?>
                    <?php
                    $link = MenuItem::urlBy($item['type'], $data);
                    $path = parse_url($link, PHP_URL_PATH);
                    ?>
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