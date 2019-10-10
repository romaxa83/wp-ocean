<?php

namespace backend\tests\unit\modules\blog\entities;

use backend\modules\blog\entities\Category;
use backend\tests\fixtures\PostCategoryFixture;

class CategoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $post Category */
    private $category;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'category' => [
                'class' => PostCategoryFixture::className(),
            ]
        ]);

        $this->category = $this->tester->grabFixture('category', 1);
    }

    public function testCreateCategory()
    {
        $category = Category::create(
            'тест',
            'test'
        );

        expect($category->title)->equals('тест');
        expect($category->alias)->equals('test');
    }

    public function testEditCategory()
    {
        $old_category = clone $this->category;

        $this->category->edit(
            'тест',
            'test'
        );

        expect($this->category->title)->equals('тест');
        expect($this->category->alias)->equals('test');
        expect($this->category->title)->notEquals($old_category->title);
        expect($this->category->alias)->notEquals($old_category->alias);
    }
}