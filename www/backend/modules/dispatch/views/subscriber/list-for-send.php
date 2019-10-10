<?php

use yii\helpers\Html;

/* @var $subscribers backend\modules\dispatch\entities\Subscriber*/
?>

<tr class="tr-more-info">
    <td colspan="6">
        <table class="table table-subscriber" data-table-for="<?= $letter_id ?? null?>">
            <caption>Выберите подписчиков для рассылки</caption>
            <thead>
            <tr>
                <th>Выбрать <?= Html::checkbox('',false,[
                        'class' => 'check-all-email',
                        'data-letter-id' => $letter_id ?? null
                    ])?></th>
                <th>E-mail <?= Html::button('Отправить',[
                        'class' => 'btn btn-sm btn-success real-send',
                        'data-letter-id' => $letter_id ?? null
                    ])?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($subscribers as $subscriber):?>
                <tr>
                    <td><?= Html::checkbox('',false,[
                            'data-id-subscriber' => $subscriber->id,
                            'data-id-letter-checkbox' => $letter_id ?? null
                        ])?></td>
                    <td><?= $subscriber->email?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </td>
</tr>
