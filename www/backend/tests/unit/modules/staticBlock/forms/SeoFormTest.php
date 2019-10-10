<?php

namespace backend\tests\unit\modules\staticBlock\forms;

use backend\modules\staticBlocks\entities\Block;
use backend\modules\staticBlocks\forms\SeoForm;

class SeoFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testEmpty()
    {
        $block = Block::create(null,null,null,null,null);
        $form = new SeoForm($block);

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Необходимо заполнить «Заголовок».');

        expect_that($form->getErrors('alias'));
        expect($form->getFirstError('alias'))
            ->equals('Необходимо заполнить «Алиас».');

        expect_that($form->getErrors('description'));
        expect($form->getFirstError('description'))
            ->equals('Необходимо заполнить «Контент».');

    }
}