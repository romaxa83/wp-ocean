<?php
/** @var array $cards */

use backend\modules\filemanager\models\Mediafile;

?>

<?php foreach($cards['cards'] as $card) : ?>
    <div class="col-xs-12 col-md-4 col-lg-4 swiper-slide">
        <div class="card card-size-s mb-0">
            <div class="card-header">
                <a href="<?= $card['url'] ?>">
                    <div class="card-header--image preloader-inner">
                        <?= Mediafile::getThumbnailById($card['cover_id'], 'original') ?>
                    </div>
                </a>
            </div>
            <div class="card-body">
                <div class="card-body--region d-flex">
                    <a href="<?= $card['url'] ?>">
                        <span class="text-uppercase"><?= $card['name'] ?></span>
                    </a>
                </div>
                <div class="card-body--desc">
                    <p>
                        <?= $card['cities'] ?>
                        <a href="<?= $card['url'] ?>" class="ways-read-more">Еще</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>