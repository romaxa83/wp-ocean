<?php

namespace backend\tests\unit\modules\faq;

use backend\modules\faq\models\Category;
use backend\modules\faq\models\Faq;
use backend\tests\fixtures\faq\FaqFixture;
use backend\modules\faq\services\FaqService;
use backend\tests\fixtures\faq\FaqCategoryFixture;

class FaqServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $faq Faq */
    private $faq;

    /** @var $category Category */
    private $category;

    /**
     * @var FaqService
     */
    private $faqService;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'faq' => [
                'class' => FaqFixture::className(),
            ],
            'category' => [
                'class' => FaqCategoryFixture::className(),
            ]
        ]);

        $this->faq = $this->tester->grabFixture('faq', 1);
        $this->category = $this->tester->grabFixture('category', 1);

        $this->faqService = new FaqService();
    }

    public function _after()
    {
        Faq::deleteAll();
    }

    public function testStatusChangeFaq()
    {
        $data = [
          'id' => $this->faq->id,
          'checked' => Faq::FAQ_UNACTIVE
        ];
        $alias = 'page_faq';

        expect($this->faq->page_faq)->equals(Faq::FAQ_ACTIVE);

        $this->faqService->changeStatus($data,$alias);

        $updateFaq = Faq::findOne($this->faq->id);
        expect($updateFaq->page_faq)->notEquals($this->faq->page_faq);
        expect($updateFaq->page_faq)->equals($data['checked']);

        expect($updateFaq->page_vip)->equals($this->faq->page_vip);
        expect($updateFaq->page_hot)->equals($this->faq->page_hot);
        expect($updateFaq->page_exo)->equals($this->faq->page_exo);
    }

    public function testStatusChangeMainFaq()
    {
        $data = [
            'id' => $this->faq->id,
            'checked' => Faq::FAQ_UNACTIVE
        ];

        expect($this->faq->status)->equals(Faq::ACTIVE);
        expect($this->faq->page_faq)->equals(Faq::FAQ_ACTIVE);
        expect($this->faq->page_vip)->equals(Faq::VIP_ACTIVE);
        expect($this->faq->page_exo)->equals(Faq::EXO_ACTIVE);
        expect($this->faq->page_hot)->equals(Faq::HOT_ACTIVE);

        $this->faqService->changeStatus($data,false);

        $updateFaq = Faq::findOne($this->faq->id);

        expect($updateFaq->status)->notEquals($this->faq->status);
        expect($updateFaq->page_faq)->notEquals($this->faq->page_faq);
        expect($updateFaq->page_vip)->notEquals($this->faq->page_vip);
        expect($updateFaq->page_exo)->notEquals($this->faq->page_exo);
        expect($updateFaq->page_hot)->notEquals($this->faq->page_hot);

        expect($updateFaq->status)->equals($data['checked']);
        expect($updateFaq->page_faq)->equals($data['checked']);
        expect($updateFaq->page_vip)->equals($data['checked']);
        expect($updateFaq->page_exo)->equals($data['checked']);
        expect($updateFaq->page_hot)->equals($data['checked']);
    }

    public function testRateChangeFaq()
    {
        $data = [
            'id' => $this->faq->id,
            'page' => 'faq',
            'value' => $this->faq->rate_faq + 10
        ];

        $this->faqService->changeRate($data);

        $updateFaq = Faq::findOne($this->faq->id);

        expect($updateFaq->rate_faq)->notEquals($this->faq->rate_faq);

        expect($updateFaq->rate_faq)->equals($data['value']);
        expect($updateFaq->rate_vip)->notEquals($data['value']);
        expect($updateFaq->rate_vip)->equals($this->faq->rate_faq);
    }

    public function testMoveUpCategory()
    {
        $position = $this->category->position;
        expect($this->category->position)->equals($position);

        $prevCategory = Category::findOne($this->category->id - 1);

        $this->faqService->moveUp($this->category);

        expect($this->category->position)->notEquals($position);
        expect($this->category->position)->equals($prevCategory->position);

        $updatePrevCategory = Category::findOne($this->category->id - 1);

        expect($updatePrevCategory->position)->notEquals($prevCategory->position);
        expect($updatePrevCategory->position)->equals($position);
    }

    public function testMoveDownCategory()
    {
        $position = $this->category->position;
        expect($this->category->position)->equals($position);

        $nextCategory = Category::findOne($this->category->id + 1);

        $this->faqService->moveDown($this->category);

        expect($this->category->position)->notEquals($position);
        expect($this->category->position)->equals($nextCategory->position);

        $updateNextCategory = Category::findOne($this->category->id + 1);

        expect($updateNextCategory->position)->notEquals($nextCategory->position);
        expect($updateNextCategory->position)->equals($position);
    }

    public function testDeleteCategoryRelationToPost()
    {
        $result = $this->faqService->removeCategory($this->category->id);
        expect($result)->equals(['error' => 'Нельзя удалить категорию,к которой привязаны посты.']);
    }
}