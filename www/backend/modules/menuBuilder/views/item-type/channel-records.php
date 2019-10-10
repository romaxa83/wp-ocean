<?php

use yii\helpers\Html;

/** @var array $records */
?>

<div class="channel-record-item">
    <div class="form-group">
        <label for="content-selector" class="control-label">Выбор записи</label>
        <?= Html::dropDownList(
            'content-selector',
            '',
            array_map(function($record) {
                return $record['title'];
            }, $records),
            array(
                'prompt' => 'Выберите запись',
                'class' => 'form-control content-selector',
                'options' => array_map(function($record) {
                    return array(
                        'data-route' => $record['slugManager']['route'],
                        'data-template' => $record['slugManager']['template'],
                        'data-parent_id' => $record['slugManager']['parent_id'],
                        'data-post_id' => $record['slugManager']['post_id']
                    );
                }, $records)
            )
        ) ?>
        <input type="hidden" name="data[parent_id]" id="content-parent_id" value="">
        <input type="hidden" name="data[post_id]" id="content-post_id" value="">
    </div>

</div>