<?php

namespace backend\modules\faq\services;

use backend\modules\faq\models\Category;
use backend\modules\faq\models\Faq;

class FaqService
{
    public function save(Faq $form) : void
    {
        $form->page_faq = $this->isPage($form,'page_faq');
        $form->page_vip = $this->isPage($form,'page_vip');
        $form->page_exo = $this->isPage($form,'page_exo');
        $form->page_hot = $this->isPage($form,'page_hot');
        $form->status = true;
        $form->created_at = time();

        if (!$form->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function update(Faq $form) : void
    {
        $form->page_faq = $this->isPage($form,'page_faq');
        $form->page_vip = $this->isPage($form,'page_vip');
        $form->page_exo = $this->isPage($form,'page_exo');
        $form->page_hot = $this->isPage($form,'page_hot');

        if (!$form->save()) {
            throw new \RuntimeException('Updating error.');
        }
    }

    public function changeStatus($post,$alias)
    {
        $faq = Faq::findOne($post['id']);
        if($alias){
            if($faq->status === FAQ::UNACTIVE){
                return false;
            } else {
                $faq->$alias = $post['checked'];
            }
        } else {
            if($post['checked'] == 0){
                $faq->status = FAQ::UNACTIVE;
                $faq->page_faq = FAQ::FAQ_UNACTIVE;
                $faq->page_vip = FAQ::VIP_UNACTIVE;
                $faq->page_exo = FAQ::EXO_UNACTIVE;
                $faq->page_hot = FAQ::HOT_UNACTIVE;
            } else {
                $faq->status = $post['checked'];
            }
        }
        if (!$faq->save()) {
            throw new \RuntimeException('Change status error.');
        }
        return true;
    }

    public function changeRate($post)
    {
        $faq = Faq::findOne($post['id']);
        switch ($post['page']) {
            case 'faq':
                $faq->rate_faq = $post['value'];
                break;

            case 'vip':
                $faq->rate_vip = $post['value'];
                break;

            case 'hot':
                $faq->rate_hot = $post['value'];
                break;

            case 'exo':
                $faq->rate_exo = $post['value'];
                break;

            default:
                throw new \DomainException('Неверные данные');
        }
        if (!$faq->save()) {
            throw new \RuntimeException('Change rate error.');
        }
    }

    public function changeStatusCategory($post) : void
    {
        $category = Category::findOne($post['id']);
        $category->status = $post['checked'];

        if (!$category->save()) {
            throw new \RuntimeException('Change status error.');
        }
    }

    public function remove($id) : void
    {
        $faq = Faq::findOne($id);

        if(!$faq->delete()){
            throw new \RuntimeException('Delete error.');
        }
    }

    private function isPage(Faq $form,string $page) : bool
    {
        return isset($form[$page]) && $form[$page] !== 0 ? true : false;
    }

    public function saveCategory(Category $form) : void
    {
        $form->status = Category::ACTIVE;
        $form->created = time();
        $form->updated = time();

        if (!$form->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function updateCategory(Category $form)
    {
        $existPosition = Category::find()->where(['position' => $form->position])->one();
        if($existPosition){
            $existPosition->position = $form->getOldAttribute('position');
            $existPosition->save();
        }
        $form->updated = time();

        if (!$form->save()) {
            throw new \RuntimeException('Updating error.');
        }
    }

    public function removeCategory($id)
    {
        $category = Category::findOne($id);

        if(Faq::find()->where(['category_id' => $id])->exists()){
            return ['error' => 'Нельзя удалить категорию,к которой привязаны посты.'];
        }

        if(!$category->delete()){
            throw new \RuntimeException('Delete error.');
        }
        return ['success' => 'Категория удалена.'];
    }

    public function moveUp(Category $category)
    {
        /** @var $next Category*/
        $next = Category::find()->where(['<','position',$category->position])
            ->orderBy(['position' => SORT_DESC])->limit(1)->one();

        if($next){
            $pos = $next->position;
            $next->position = $category->position;
            $category->position = $pos;
            $next->save();
            $category->save();
        }
    }

    public function moveDown(Category $category)
    {
        /** @var $prev Category*/
        $prev = Category::find()->where(['>','position',$category->position])
            ->orderBy(['position' => SORT_ASC])->limit(1)->one();
        if($prev){
            $pos = $prev->position;
            $prev->position = $category->position;
            $category->position = $pos;
            $prev->save();
            $category->save();
        }
    }
}