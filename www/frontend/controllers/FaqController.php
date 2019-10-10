<?php

namespace frontend\controllers;

use Yii;
use yii\base\Module;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\faq\repository\FaqRepository;
use backend\modules\faq\repository\FaqCategoryRepository;

class FaqController extends BaseController
{
    /**
     * @var FaqCategoryRepository
     */
    private $faqCategoryRepository;

    /**
     * @var FaqRepository
     */
    private $faqRepository;

    public function __construct($id, Module $module,
                                FaqCategoryRepository $faqCategoryRepository,
                                FaqRepository $faqRepository,
                                array $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->faqCategoryRepository = $faqCategoryRepository;
        $this->faqRepository = $faqRepository;
    }

    public function actionCategory($slug = false)
    {
        if(!$slug){
            if($category = $this->faqCategoryRepository->getFirstPositionCategory()){
                $slug = $category->alias;
            }
        }

        if($categories = $this->faqCategoryRepository->getAllCategoryForFront()){
            $this->renderBreadcrumbs($this->generateBreadcrumbs($slug));
        }

        return $this->render('index',[
            'categories' => $categories,
            'categoryActive' => $slug,
            'faqs' => $this->faqRepository->getAllFaqByCategoryAlias($slug),
            'searchInputValue' => ''
        ]);
    }

    public function actionShowAnyFaq()
    {
        $post = \Yii::$app->request->post();

        return $this->redirect([$post['url']],301);
    }

    public function actionMiddleware()
    {
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();

            return $this->redirect(Url::toRoute(['faq/search','str' =>trim(Html::encode($post['search']))]),301);
        }
    }

    public function actionSearch($params)
    {
        if($categories = $this->faqCategoryRepository->getAllCategoryForFront()){
            $this->renderBreadcrumbs($this->generateBreadcrumbs());
        }

        return $this->render('index',[
            'categories' => $this->faqCategoryRepository->getAllCategoryForFront(),
            'categoryActive' => '',
            'faqs' => $this->faqRepository->getFaqsBySearch(trim(Html::encode($params))),
            'searchInputValue' => $params
        ]);
    }

    private function generateBreadcrumbs($slug = false)
    {
        if(!$faq = $this->faqCategoryRepository->getFirstPositionCategory()){
            return false;
        }

        $category = $this->faqCategoryRepository->getCategoryByAlias($slug);

        $base = [
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ],
            [
                'href' => Url::to('/faq/category/'.$faq->alias, TRUE),
                'name' => 'F.A.Q.'
            ],
        ];

        if($slug){
            $base[] = [
                'href' => Url::to('/faq/category/'.$slug, TRUE),
                'name' => $category->name
            ];
        } else {
            $base[] = [
                'href' => '#',
                'name' => 'Поиск'
            ];
        }
        return $base;
    }
}
