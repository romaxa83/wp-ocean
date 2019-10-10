<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div id="select-type-widget">
    <div class="form-group">
        <label for="item-type" class="control-label">Тип элемента</label>
        <div class="input-group">
            <?= Html::dropDownList(
                'type',
                '',
                Yii::$app->getModule('menuBuilder')->params['itemTypes'],
                array(
                    'prompt' => 'Выберите тип элемента',
                    'class' => 'form-control',
                    'id' => 'item-type'
                )
            ) ?>

            <span class="input-group-btn">
            <button type="button" id="select-type" class="btn btn-info">Выбрать</button>
        </span>
        </div>
    </div>
</div>