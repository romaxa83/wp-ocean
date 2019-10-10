<?php

namespace backend\modules\referenceBooks\models;

use yii\grid\ActionColumn;

class CustomActionColumn extends ActionColumn {

    public $filter;

    protected function renderFilterCellContent() {
        return $this->filter;
    }

}
