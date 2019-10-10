<?php

namespace backend\tests\unit\modules\blog\forms;

use backend\modules\blog\entities\Tag;
use backend\modules\blog\forms\TagForm;

class TagFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testTagEmpty()
    {
        $tag = Tag::create(null,null);
        $form = new TagForm($tag);

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Необходимо заполнить «Название тега».');

        expect_that($form->getErrors('alias'));
        expect($form->getFirstError('alias'))
            ->equals('Необходимо заполнить «Алиас тега».');

    }
}