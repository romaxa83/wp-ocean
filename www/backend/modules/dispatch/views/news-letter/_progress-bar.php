<?php

/* @var $data backend\modules\dispatch\entities\Statistic*/

?>

<?php if($data):?>
    <?php
    $percent = ceil(((int)$data->sended*100)/$data->all) != 0
        ?ceil(((int)$data->sended*100)/$data->all)
        :1;
    $width = 'width:'.$percent.'%';
    ?>
    <?php if($data->end_time !== null):?>
        <span><?= $percent?>% Процесс(<?= $data->sended.'/'. $data->all ?>)</span>
    <?php else:?>
        <div class="progress progress-for-dispatch-letter" data-letter-id="<?=$data->letter_id?>">
            <div class="progress-bar progress-bar-striped active"
                 role="progressbar"
                 aria-valuenow="90"
                 aria-valuemin="0"
                 aria-valuemax="100"
                 style="<?=$width?>">
        <span class="progress-color">
        <?= $percent?>% Процесс(<?= $data->sended.'/'. $data->all ?>)
        </span>
            </div>
        </div>
    <?php endif;?>
<?php else:?>
    <span style="color: rgb(221,75,57)">Нет данных</span>
<?php endif;?>
