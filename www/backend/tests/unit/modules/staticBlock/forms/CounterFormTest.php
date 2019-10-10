<?php

namespace backend\tests\unit\modules\staticBlock\forms;

use backend\modules\staticBlocks\entities\Block;
use backend\modules\staticBlocks\forms\CounterForm;

class CounterFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testEmpty()
    {
        $block = Block::create(null,null,null,null,null);
        $form = new CounterForm($block);

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Необходимо заполнить «Верхний (числовой) предел».');

        expect_that($form->getErrors('description'));
        expect($form->getFirstError('description'))
            ->equals('Необходимо заполнить «Текст».');

    }

    public function testWrongNumber()
    {
        $block = Block::create('test',null,null,null,null);
        $form = new CounterForm($block);

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Данные должны быть в числовом формате');

        expect_that($form->getErrors('description'));
        expect($form->getFirstError('description'))
            ->equals('Необходимо заполнить «Текст».');

    }

    public function testListPosition()
    {
        $list = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4'
        ];

        $formList = (new CounterForm())->listPosition();

        expect($list)->equals($formList);
    }
}