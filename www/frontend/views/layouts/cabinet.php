<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\user\widgets\user\UserWidgetAsset;
?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

    <div class="row">
        <aside id="column-right" class="col-sm-3 hidden-xs">
            <div class="list-group">
                <a href="<?= Html::encode(Url::to(['/cabinet/order/index'])) ?>" class="list-group-item">История заказов</a>
                <a href="<?= Html::encode(Url::to(['/cabinet/dispatch/index'])) ?>" class="list-group-item">SMART-рассылка</a>
                <a href="<?= Html::encode(Url::to(['/cabinet/settings/index'])) ?>" class="list-group-item cabinet-settings-navbar">Настройки</a>
                <a href="<?= Html::encode(Url::to(['/cabinet/favorites/index'])) ?>" class="list-group-item">Избраное</a>
                <a href="<?= Html::encode(Url::to(['/site/reviews'])) ?>" class="list-group-item">Review(dev)</a>
                <a href="<?= Html::encode(Url::to(['/site/logout'])) ?>" data-method="post" class="list-group-item">Exit</a>
            </div>
        </aside>
        <div id="content" class="col-sm-9">
            <?= $content ?>
        </div>
    </div>

<?php $this->endContent() ?>