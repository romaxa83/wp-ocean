<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="group-item">
    <div class="form-group">
        <label for="content-selector" class="control-label">Выбор шаблона</label>
        <?= Html::dropDownList(
            'data[template]',
            '',
            Yii::$app->getModule('menuBuilder')->params['groupTemplates'],
            array(
                'prompt' => 'Выберите шаблон группы',
                'class' => 'form-control',
                'id' => 'item-type'
            )
        ) ?>
    </div>
    <div class="form-group">
        <input type="hidden" name="type" value="group">
        <label for="title" class="control-label">Название группы</label>
        <input type="text" name="title" id="group-title" class="form-control" placeholder="Название">
    </div>
</div>