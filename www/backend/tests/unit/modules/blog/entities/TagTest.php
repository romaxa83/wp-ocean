<?php

namespace backend\tests\unit\modules\blog\entities;

use backend\modules\blog\entities\Post;
use backend\modules\blog\entities\Tag;
use backend\tests\fixtures\PostFixture;
use backend\tests\fixtures\TagFixture;

class TagTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $post Post */
    private $post;

    /** @var $tag Tag */
    private $tag;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'post' => [
                'class' => PostFixture::className(),
            ],
            'tag' => [
                'class' => TagFixture::className(),
            ]
        ]);

        $this->post = $this->tester->grabFixture('post', 1);
        $this->tag = $this->tester->grabFixture('tag', 1);
    }

    public function testCreateTag()
    {
        $tag = Tag::create(
            'тест',
            'test'
        );

        expect($tag->title)->equals('тест');
        expect($tag->alias)->equals('test');
        expect($tag->save())->true();
    }

    public function testEditTag()
    {
        $old_tag = clone $this->tag;

         $this->tag->edit(
            'тест',
            'test'
        );

        expect($this->tag->title)->equals('тест');
        expect($this->tag->alias)->equals('test');
        expect($this->tag->title)->notEquals($old_tag->title);
        expect($this->tag->alias)->notEquals($old_tag->alias);
        expect($this->tag->save())->true();
    }

    public function testStatus()
    {
        $old_tag = clone $this->tag;
        expect($old_tag->status)->equals(Tag::STATUS_ACTIVE);

        $this->tag->status(Tag::STATUS_INACTIVE);

        expect($this->tag->status)->equals(Tag::STATUS_INACTIVE);
        expect($this->tag->status)->notEquals(Tag::STATUS_ACTIVE);
        expect($this->tag->save())->true();
    }

    public function testSlugGenerator()
    {
        $slug = $this->tag::generateAlias('Тест');
        expect($slug)->equals('test');
    }

    public function testReletion()
    {
        expect($this->tag->posts[0]->title)->equals('Title_1');
        expect($this->tag->posts[1]->title)->equals('Title_3');
    }
}