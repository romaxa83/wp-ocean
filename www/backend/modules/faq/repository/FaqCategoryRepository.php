<?php

namespace backend\modules\faq\repository;

use backend\modules\faq\models\Category;

class FaqCategoryRepository
{
    public function getAllCategoryForFront()
    {
        return Category::find()
            ->where(['status' => Category::ACTIVE])
            ->orderBy(['position' => SORT_ASC])
            ->all();
    }

    public function getFirstPositionCategory()
    {
        return Category::find()
            ->where(['status' => Category::ACTIVE])
            ->orderBy(['position' => SORT_ASC])->limit(1)
            ->one();
    }

    public function getCategoryByAlias($alias)
    {
        return Category::find()->where(['alias' => $alias])->one();
    }
}