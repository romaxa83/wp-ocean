<?php

use yii\helpers\Html;

/** @var array $pages */
?>
<div class="page-item">
    <div class="form-group">
        <label for="content-selector" class="control-label">Выбор страницы</label>
        <?= Html::dropDownList(
            'content-selector',
            '',
            array_map(function($page) {
                return $page['title'];
            }, $pages),
            array(
                'prompt' => 'Выберите страницу',
                'class' => 'form-control content-selector',
                'options' => array_map(function($page) {
                    return array(
                        'data-route' => $page['slugManager']['route'],
                        'data-template' => $page['slugManager']['template'],
                        'data-slug' => $page['slugManager']['slug'],
                        'data-parent_id' => $page['slugManager']['parent_id'],
                        'data-post_id' => $page['slugManager']['post_id']
                    );
                }, $pages)
            )
        ) ?>
    </div>
    <div id="step-2" class="form-group hidden">
        <input type="hidden" name="type" value="route">
        <input type="hidden" name="data[route]" id="content-route" value="">
        <input type="hidden" name="data[template]" id="content-template" value="">
        <input type="hidden" name="data[slug]" id="content-slug" value="">
        <label for="title" class="control-label">Название</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Название">
    </div>
</div>
