<?php

namespace backend\tests\unit\modules\faq\models;

use backend\modules\faq\models\Faq;
use backend\modules\faq\models\Category;
use backend\tests\fixtures\faq\FaqFixture;
use backend\tests\fixtures\faq\FaqCategoryFixture;

class FaqTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $category Category */
    private $category;

    /** @var $faq Faq */
    private $faq;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'category' => [
                'class' => FaqCategoryFixture::className(),
            ],
            'faq' => [
                'class' => FaqFixture::className(),
            ]
        ]);

        $this->category = $this->tester->grabFixture('category', 1);

        $this->faq = $this->tester->grabFixture('faq', 2);
    }

    public function testCreate()
    {
        $date = (new \DateTimeImmutable('now'))->getTimestamp();
        $data = [
            'category_id' => $this->category->id,
            'question' => 'who?',
            'answer' => 'anybody',
            'page_faq' => 1,
            'rate_faq' => 1,
            'page_hot' => 1,
            'rate_hot' => 1,
            'page_exo' => 0,
            'rate_exo' => 6,
            'page_vip' => 0,
            'status' => 1,
            'created_at' => $date,
        ];

        $faq = $this->generateFaq($data);

        expect_that($faq->validate());
        expect($faq->save())->true();

        expect($faq->category->name)->equals($this->category->name);
        expect($faq->question)->equals($data['question']);
        expect($faq->answer)->equals($data['answer']);
        expect($faq->page_faq)->equals($data['page_faq']);
        expect($faq->rate_faq)->equals($data['rate_faq']);
        expect($faq->page_hot)->equals($data['page_hot']);
        expect($faq->rate_hot)->equals($data['rate_hot']);
        expect($faq->page_exo)->equals($data['page_exo']);
        expect($faq->rate_exo)->equals($data['rate_exo']);
        expect($faq->page_vip)->equals($data['page_vip']);
        expect($faq->rate_vip)->equals(0);
        expect($faq->status)->equals($data['status']);
        expect($faq->created_at)->equals($data['created_at']);
    }

    public function testCreateWrong()
    {
        $data = [];

        $faq = $this->generateFaq($data);

        expect_not($faq->validate());

        expect_that($faq->getErrors('category_id'));
        expect_that($faq->getErrors('question'));
        expect_that($faq->getErrors('answer'));

        expect($faq->getFirstError('category_id'))
            ->equals('Необходимо заполнить «Категория».');

        expect($faq->getFirstError('question'))
            ->equals('Необходимо заполнить «Вопрос».');

        expect($faq->getFirstError('answer'))
            ->equals('Необходимо заполнить «Ответ».');

        expect($faq->save())->false();
    }

    public function testEdit()
    {
        $date = (new \DateTimeImmutable('now'))->getTimestamp();

        $oldFaq = clone $this->faq;

        $data = [
            'category_id' => $this->category->id,
            'question' => 'who?',
            'answer' => 'anybody',
            'page_faq' => 1,
            'rate_faq' => 5,
            'page_hot' => 1,
            'rate_hot' => 5,
            'page_exo' => 1,
            'rate_exo' => 6,
            'page_vip' => 1,
            'rate_vip' => 7,
            'status' => 1,
            'created_at' => $date,
        ];

        $faq = $this->generateFaq($data,$this->faq);

        expect_that($faq->validate());
        expect($faq->save())->true();

        expect($faq->category_id)->notEquals($oldFaq->category_id);
        expect($faq->category_id)->equals($data['category_id']);

        expect($faq->question)->notEquals($oldFaq->question);
        expect($faq->question)->equals($data['question']);

        expect($faq->answer)->notEquals($oldFaq->answer);
        expect($faq->answer)->equals($data['answer']);

        expect($faq->page_faq)->notEquals($oldFaq->page_faq);
        expect($faq->page_faq)->equals($data['page_faq']);

        expect($faq->rate_faq)->notEquals($oldFaq->rate_faq);
        expect($faq->rate_faq)->equals($data['rate_faq']);

        expect($faq->page_hot)->notEquals($oldFaq->page_hot);
        expect($faq->page_hot)->equals($data['page_hot']);

        expect($faq->rate_hot)->notEquals($oldFaq->rate_hot);
        expect($faq->rate_hot)->equals($data['rate_hot']);

        expect($faq->page_exo)->notEquals($oldFaq->page_exo);
        expect($faq->page_exo)->equals($data['page_exo']);

        expect($faq->rate_exo)->notEquals($oldFaq->rate_exo);
        expect($faq->rate_exo)->equals($data['rate_exo']);

        expect($faq->page_vip)->notEquals($oldFaq->page_vip);
        expect($faq->page_vip)->equals($data['page_vip']);

        expect($faq->rate_vip)->notEquals($oldFaq->rate_vip);
        expect($faq->rate_vip)->equals($data['rate_vip']);

        expect($faq->status)->notEquals($oldFaq->status);
        expect($faq->status)->equals($data['status']);
    }

    private function generateFaq($data,$model=null)
    {
        if($model){
            $faq = $model;
        } else {
            $faq = new Faq();
        }
        $faq->category_id = $data['category_id']??null;
        $faq->question = $data['question']??null;
        $faq->answer = $data['answer']??null;
        $faq->page_faq = $data['page_faq']??null;
        $faq->rate_faq = $data['rate_faq']??null;
        $faq->page_hot = $data['page_hot']??null;
        $faq->rate_hot = $data['rate_hot']??null;
        $faq->page_exo = $data['page_exo']??null;
        $faq->rate_exo = $data['rate_exo']??null;
        $faq->page_vip = $data['page_vip']??null;
        $faq->rate_vip = $data['rate_vip']??null;
        $faq->status = $data['status']??null;
        $faq->created_at = $data['created_at']??null;

        return $faq;
    }
}