<?php

namespace backend\tests\unit\modules\blog\forms;

use backend\modules\blog\entities\Category;
use backend\modules\blog\forms\CategoryForm;

class CategoryFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testTagEmpty()
    {
        $tag = Category::create(null,null);
        $form = new CategoryForm($tag);

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Необходимо заполнить «Название категории».');

        expect_that($form->getErrors('alias'));
        expect($form->getFirstError('alias'))
            ->equals('Необходимо заполнить «Алиас категории».');
    }
}