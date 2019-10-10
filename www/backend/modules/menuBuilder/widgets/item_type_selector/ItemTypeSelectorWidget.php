<?php

namespace backend\modules\menuBuilder\widgets\item_type_selector;

use yii\base\Widget;

class ItemTypeSelectorWidget extends Widget
{
    public function run()
    {
        return $this->render('type-selector');
    }
}