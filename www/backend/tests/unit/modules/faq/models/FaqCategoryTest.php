<?php

namespace backend\tests\unit\modules\faq\models;

use backend\modules\faq\models\Category;
use backend\tests\fixtures\MediaFixture;
use backend\modules\filemanager\models\Mediafile;
use backend\tests\fixtures\faq\FaqCategoryFixture;

class FaqCategoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $category Category */
    private $category;

    /** @var $media Mediafile */
    private $media;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'category' => [
                'class' => FaqCategoryFixture::className(),
            ],
            'media' => [
                'class' => MediaFixture::className(),
            ]
        ]);

        $this->category = $this->tester->grabFixture('category', 1);

        $this->media = $this->tester->grabFixture('media',5);
    }

    public function testCreate()
    {
        $date = (new \DateTimeImmutable('now'))->getTimestamp();
        $data = [
            'name' => 'Отели',
            'alias' => 'oteli',
            'position' => 1,
            'media_id' => $this->media->id,
            'status' => 1,
            'created' => $date,
            'updated' => $date
        ];

        $faqCategory = $this->generateFaqCategory($data);

        expect_that($faqCategory->validate());
        expect($faqCategory->save())->true();
        expect($faqCategory->name)->equals($data['name']);
        expect($faqCategory->alias)->equals($data['alias']);
        expect($faqCategory->position)->equals($data['position']);
        expect($faqCategory->status)->equals($data['status']);
        expect($faqCategory->icon->filename)->equals($this->media->filename);
        expect($faqCategory->created)->notNull();
        expect($faqCategory->created)->equals($date);
        expect($faqCategory->updated)->notNull();
        expect($faqCategory->updated)->equals($date);
    }

    public function testCreateWrong()
    {
        $date = (new \DateTimeImmutable('now'))->getTimestamp();
        $data = [
            'name' => null,
            'alias' => null,
            'position' => 1,
            'status' => 1,
            'created' => $date,
            'updated' => $date
        ];

        $faqCategory = $this->generateFaqCategory($data);

        expect_not($faqCategory->validate());

        expect_that($faqCategory->getErrors('name'));
        expect_that($faqCategory->getErrors('alias'));

        expect($faqCategory->getFirstError('name'))
            ->equals('Необходимо заполнить «Название».');

        expect($faqCategory->getFirstError('alias'))
            ->equals('Необходимо заполнить «Алиас».');

        expect($faqCategory->save())->false();
    }

    public function testEdit()
    {
        $date = (new \DateTimeImmutable('now'))->getTimestamp();

        $oldFaqCategory = clone $this->category;

        $data = [
            'name' => 'Отели',
            'alias' => 'oteli',
            'media_id' => $this->media->id,
            'position' => 5,
            'status' => 1,
            'updated' => $date
        ];

        $faqCategory = $this->generateFaqCategory($data,$this->category);

        expect_that($faqCategory->validate());
        expect($faqCategory->save())->true();
        expect($faqCategory->name)->notEquals($oldFaqCategory->name);
        expect($faqCategory->name)->equals($data['name']);
        expect($faqCategory->alias)->notEquals($oldFaqCategory->alias);
        expect($faqCategory->alias)->equals($data['alias']);

        expect($faqCategory->position)->notEquals($oldFaqCategory->position);
        expect($faqCategory->media_id)->notEquals($oldFaqCategory->media_id);

        expect($faqCategory->created)->equals($oldFaqCategory->created);
    }

    private function generateFaqCategory($data,$model=null)
    {
        if($model){
            $category = $model;
        } else {
            $category = new Category();
        }
        $category->name = $data['name'];
        $category->alias = $data['alias'];
        $category->media_id = $data['media_id']??null;
        $category->position = $data['position'];
        $category->status = $data['status'];
        if($model && !isset($data['created'])){

        } else {

            $category->created = $data['created'];
        }
        $category->updated = $data['updated'];

        return $category;
    }
}