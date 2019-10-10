<?php

use alexeevdv\yii\BootstrapToggleWidget;
use backend\modules\menuBuilder\widgets\menuItem\MenuItemWidget;

/* @var $title string */
/* @var $menuId int */
/* @var $type string */
/* @var $data string */
/* @var $status int */
/* @var $id int */
/* @var $parent_id int */
/* @var $children array */
?>
<li data-menu_id="<?= $menuId ?>"
    data-type="<?= $type ?>"
    data-data='<?= $data ?>'
    data-status="<?= $status ?>"
    data-id="<?= $id ?>"
    data-parent_id="<?= $parent_id ?>"
>
    <div class="item">
        <span class="title-container">
            <i class="fa fa-fw fa-arrows icon-move"></i>
            <span class="title"><?= $title ?></span>
        </span>
        <div class="btn-group pull-right">
            <?= BootstrapToggleWidget::widget([
                'name' => 'is_enabled',
                'value' => $status,
                'labelEnabled' => 'Вкл',
                'labelDisabled' => 'Выкл',
                'valueEnabled' => 1,
                'valueDisabled' => 0,
                'containerOptions' => ['class' => 'switcher'],
            ]); ?>
            <button type="button" class="btn btn-default edit-menu-item" title="Редактировать"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-default delete-menu-item" title="Удалить"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
    <div class="input-group input-group-sm title-edit hidden">
        <input type="text" name="title-edit" class="form-control">
        <span class="input-group-btn">
          <button type="button" class="btn btn-success btn-flat change-title"><i class="fa fa-check"></i></button>
        </span>
    </div>
    <?php if($type == 'group') : ?>
        <ol class="sub-menu">
            <?php foreach($children as $item) : ?>
                <?= MenuItemWidget::widget([
                    'id' => $item['id'],
                    'parent_id' => $item['parent_id'],
                    'title' => $item['title'],
                    'menuId' => $item['menu_id'],
                    'type' => $item['type'],
                    'data' => $item['data'],
                    'status' => $item['status']
                ]) ?>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</li>