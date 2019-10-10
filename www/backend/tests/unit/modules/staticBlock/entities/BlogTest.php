<?php

namespace backend\tests\unit\modules\staticBlock\entities;

use backend\modules\staticBlocks\entities\Block;
use backend\tests\fixtures\MediaFixture;
use backend\tests\fixtures\StaticBlocksFixture;

class BlogTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $block Block */
    private $block;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'block' => [
                'class' => StaticBlocksFixture::className(),
            ],
            'media' => [
                'class' => MediaFixture::className(),
            ],
        ]);

        $this->block = $this->tester->grabFixture('block', 10);
    }

    public function testCreate()
    {
        $data = [
            'title' => 'test_title',
            'alias' => 'test_title',
            'description' => 'test_description',
            'position' => 1,
            'block' => 'seo',
        ];

        $block = Block::create(
            $data['title'],
            $data['alias'],
            $data['description'],
            $data['position'],
            $data['block']
        );

        expect($block->title)->equals($data['title']);
        expect($block->alias)->equals($data['alias']);
        expect($block->description)->equals($data['description']);
        expect($block->position)->equals($data['position']);
        expect($block->block)->equals($data['block']);
        expect($block->status)->equals(Block::STATUS_ACTIVE);
        expect($block->status_block)->equals(Block::STATUS_BLOCK_ACTIVE);
        expect($block->save())->true();
    }

    public function testEdit()
    {
        expect($this->block->status)->equals(Block::STATUS_INACTIVE);
        expect($this->block->status_block)->equals(Block::STATUS_BLOCK_INACTIVE);

        $data = [
            'title' => 'update_title',
            'alias' => 'update_alias',
            'description' => 'update_description',
            'position' => 7,
        ];

        $this->block->edit(
            $data['title'],
            $data['alias'],
            $data['description'],
            $data['position']
        );

        expect($this->block->title)->equals($data['title']);
        expect($this->block->alias)->equals($data['alias']);
        expect($this->block->description)->equals($data['description']);
        expect($this->block->position)->equals($data['position']);
        expect($this->block->status)->equals(Block::STATUS_INACTIVE);
        expect($this->block->status_block)->equals(Block::STATUS_BLOCK_INACTIVE);
        expect($this->block->save())->true();
    }

    public function testStatus()
    {
        $old_block = clone $this->block;
        expect($old_block->status)->equals(Block::STATUS_INACTIVE);

        $this->block->status(Block::STATUS_ACTIVE);

        expect($this->block->status)->equals(Block::STATUS_ACTIVE);
        expect($this->block->save())->true();
    }

    public function testPosition()
    {
        $position = 7;
        $old_block = clone $this->block;
        expect($old_block->position)->notEquals($position);

        $this->block->changePosition($position);

        expect($this->block->position)->equals($position);
        expect($this->block->save())->true();
    }

    public function testReletion()
    {
        $blockVideo = $this->tester->grabFixture('block', 'video');
        $preview = $this->tester->grabFixture('media', $blockVideo->title);
        $video = $this->tester->grabFixture('media', $blockVideo->description);

        expect($blockVideo->video->filename)->equals($video->filename);
        expect($blockVideo->preview->filename)->equals($preview->filename);
    }
}