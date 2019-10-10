<?php

use yii\helpers\Html;

/** @var array $filters */
?>

<div class="channel-item">
    <div class="form-group">
        <label for="content-selector" class="control-label">Выбор фильтра</label>
        <?= Html::dropDownList(
            'content-selector',
            '',
            array_map(function($filter) {
                return $filter['name'];
            }, $filters),
            array(
                'prompt' => 'Выберите фильтр',
                'class' => 'form-control content-selector',
                //'id' => 'channel-main',
                'options' => array_map(function($filter) {
                    return array(
                        'data-route' => $filter['alias'],
                    );
                }, $filters)
            )
        ) ?>
    </div>
<div class="blog-item">
    <div class="form-group">
        <input type="hidden" name="type" value="filter">
        <input type="hidden" name="data[route]" id="content-route" value="">
        <label for="title" class="control-label">Название</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Название">
    </div>
</div>