<?php

namespace backend\modules\menuBuilder\widgets\menuItem;

use backend\modules\menuBuilder\models\MenuItem;
use yii\base\Widget;

class MenuItemWidget extends Widget
{
    public $id;
    public $parent_id;
    public $title;
    public $menuId;
    public $type;
    public $data;
    public $status;

    public $children = array();

    public function run()
    {
        if($this->type == 'group') {
            $this->children = MenuItem::find()->where(['parent_id' => $this->id])->asArray()->all();
        }

        return $this->render('menu-item', [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'title' => $this->title,
            'menuId' => $this->menuId,
            'type' => $this->type,
            'data' => $this->data,
            'status' => $this->status,
            'children' => $this->children,
        ]);
    }
}