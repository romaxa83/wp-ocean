<?php

namespace backend\modules\menuBuilder\models;

use paulzi\adjacencyList\AdjacencyListQueryTrait;
use yii\db\ActiveQuery;

class MenuItemQuery extends ActiveQuery
{
    use AdjacencyListQueryTrait;

    public function roots()
    {
        /** @var \yii\db\ActiveQuery $this */
        $class = $this->modelClass;
        $model = new $class;
        return $this->andWhere([$model->parentAttribute => 0]);
    }
}