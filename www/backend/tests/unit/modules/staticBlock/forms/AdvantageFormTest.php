<?php

namespace backend\tests\unit\modules\staticBlock\forms;

use backend\modules\staticBlocks\entities\Block;
use backend\modules\staticBlocks\forms\AdvantageForm;

class AdvantageFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testEmpty()
    {
        $block = Block::create(null,null,null,null,null);
        $form = new AdvantageForm($block);

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Необходимо заполнить «Иконка».');

        expect_that($form->getErrors('description'));
        expect($form->getFirstError('description'))
            ->equals('Необходимо заполнить «Описание».');

    }

    public function testListPosition()
    {
        $list = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4'
        ];

        $formList = (new AdvantageForm())->listPosition();

        expect($list)->equals($formList);
    }
}