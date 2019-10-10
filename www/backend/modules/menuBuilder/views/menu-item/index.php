<?php

use alexeevdv\yii\BootstrapToggleWidget;
use backend\modules\menuBuilder\widgets\item_type_selector\ItemTypeSelectorWidget;
use backend\modules\menuBuilder\widgets\menuItem\MenuItemWidget;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $menu array */

$this->title = "Редактировать \"{$menu['label']}\"";
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['/menuBuilder/menu']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content">
    <div class="alert alert-success alert-dismissible hidden">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-check"></i>Данные сохранены.
    </div>

    <div class="row">
        <div class="col-md-6">
            <div id="item-configurator" class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Добавить элемент</h3>
                </div>
                <div class="box-body">
                    <?= ItemTypeSelectorWidget::widget() ?>
                    <div id="item-form"></div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                    <button type="submit" id="add-item" class="btn btn-primary pull-right" disabled="true">Добавить</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Редактор меню</h3>
                </div>
                <div class="box-body">
                    <ol id="menu" class="sortable">
                        <?php foreach($menu['menuItems'] as $item) : ?>
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
                </div>
                <div class="box-footer">
                    <input type="hidden" name="menu-action" value="<?= Url::to('/admin/menuBuilder/menu-item/store', true) ?>">
                    <button type="submit" id="save-menu" class="btn btn-primary pull-right">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</div>