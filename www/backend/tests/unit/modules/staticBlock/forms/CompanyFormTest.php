<?php

namespace backend\tests\unit\modules\staticBlock\forms;

use backend\modules\staticBlocks\entities\Block;
use backend\modules\staticBlocks\forms\CompanyForm;

class CompanyFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testEmpty()
    {
        $block = Block::create(null,null,null,null,null);
        $form = new CompanyForm($block);

        expect_not($form->validate());

        expect_that($form->getErrors('description'));
        expect($form->getFirstError('description'))
            ->equals('Необходимо заполнить «Текст».');

    }

    public function testEmptyVideo()
    {
        $block = Block::create(null,'video',null,null,null);
        $form = new CompanyForm($block);

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Необходимо заполнить «Картинка для превью».');

        expect_that($form->getErrors('description'));
        expect($form->getFirstError('description'))
            ->equals('Необходимо заполнить «Видео».');

    }

    public function testListPosition()
    {
        $list = [
            '1' => '1',
            '2' => '2',
            '3' => '3'
        ];

        $formList = (new CompanyForm())->listPosition();

        expect($list)->equals($formList);
    }
}