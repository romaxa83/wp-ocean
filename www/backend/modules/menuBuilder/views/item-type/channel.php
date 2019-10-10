<?php

use yii\helpers\Html;

/** @var array $channels */
?>

<div class="channel-item">
    <div class="form-group">
        <label for="content-selector" class="control-label">Выбор канала</label>
        <?= Html::dropDownList(
            'content-selector',
            '',
            array_map(function($channel) {
                return $channel['title'];
            }, $channels),
            array(
                'prompt' => 'Выберите канал',
                'class' => 'form-control content-selector',
                'id' => 'channel-main',
                'options' => array_map(function($channel) {
                    return array(
                        'data-route' => $channel['slugManager']['route'],
                        'data-template' => $channel['slugManager']['template'],
                        'data-parent_id' => $channel['slugManager']['parent_id'],
                        'data-post_id' => $channel['slugManager']['post_id']
                    );
                }, $channels)
            )
        ) ?>
    </div>
    <div id="step-2" class="hidden">
        <div class="form-group">
            <input type="hidden" name="channel-records-action" value="<?= \yii\helpers\Url::to('/admin/menuBuilder/item-type/get-channel-records') ?>"
            <span>
                <label>
                    <input type="radio" name="channelGroup" value="channel" checked="">
                    Канал
                </label>
            </span>
                <span>
                <label>
                    <input type="radio" name="channelGroup" value="records">
                    Записи
                </label>
            </span>
        </div>
        <div id="data">

        </div>
        <div class="form-group">
            <input type="hidden" name="type" value="route">
            <input type="hidden" name="data[route]" id="content-route" value="">
            <input type="hidden" name="data[template]" id="content-template" value="">
            <label for="title" class="control-label">Название</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Название">
        </div>
    </div>
</div>