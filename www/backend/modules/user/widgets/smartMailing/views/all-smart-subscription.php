<?php

/* @var $smarts backend\modules\user\entities\SmartMailing */
/* @var $admin */

use backend\modules\user\helpers\DateFormat;
use backend\modules\user\helpers\SmartMailingHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if($smarts):?>
    <div>
        <?= !($admin)?'<h3>Вы уже подписаны</h3>':''?>
        <?php foreach ($smarts as $smart):?>
            <div class="row" style="padding:10px 10px 10px 10px;margin-bottom: 20px;<?= !($admin)?'border:1px solid grey':''?>">
                <div class="col-md-<?= ($admin)?'2':'2'?>">
                    <?= $smart->country->name?>
                </div>
                <div class="col-md-<?= ($admin)?'3':'2'?>">
                    С - <?= DateFormat::forView($smart->with)?>
                </div>
                <div class="col-md-<?= ($admin)?'3':'2'?>">
                    По -  <?= DateFormat::forView($smart->to)?>
                </div>
                <div class="col-md-<?= ($admin)?'2':'1'?>">
                    <?= $smart->persons?> человека
                </div>
                <div class="col-md-<?= ($admin)?'2':'1'?>">
                    <?= SmartMailingHelper::getPrettyType($smart->type_send)?>
                </div>
                <?php if(!$admin):?>
                    <div class=" col-md-2 col-md-offset-2">
                        <?= Html::a('<span class="glyphicon glyphicon-remove" style="float:right;cursor:pointer" title="" aria-hidden="true"></span>',
                            Url::toRoute(['/cabinet/dispatch/remove']),
                            [
                                'data-confirm' => 'Вы уверены ?',
                                'data-method' => 'POST',
                                'data-params' => [
                                'id' => $smart->id,
                            ]
                        ])?>
                    </div>
                <?php endif;?>
            </div>
        <?php endforeach;?>
    </div>
<?php endif;?>
