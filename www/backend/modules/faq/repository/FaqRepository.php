<?php

namespace backend\modules\faq\repository;

use backend\modules\faq\models\Faq;

class FaqRepository
{
    /**
     * @var FaqCategoryRepository
     */
    private $faqCategoryRepository;

    public function __construct(FaqCategoryRepository $faqCategoryRepository)
    {
        $this->faqCategoryRepository = $faqCategoryRepository;
    }

    public function getAllFaqByCategoryAlias($alias)
    {
        if($category = $this->faqCategoryRepository->getCategoryByAlias($alias)){

            return Faq::find()
                ->where(['category_id' => $category->id])
                ->andWhere(['status' => Faq::ACTIVE])
                ->andWhere(['page_faq' => Faq::FAQ_ACTIVE])
                ->orderBy(['rate_faq' => SORT_ASC])
                ->all();
        }

        return false;
    }

    public function getFaqsBySearch($search)
    {
        if($search == ''){
            return false;
        }
        return Faq::find()
            ->where(['status' => Faq::ACTIVE])
            ->andWhere(['like','question',$search])
            ->orderBy(['rate_faq' => SORT_ASC])
            ->all();
    }
}