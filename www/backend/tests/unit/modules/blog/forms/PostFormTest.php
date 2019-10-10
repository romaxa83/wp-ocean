<?php

namespace backend\tests\unit\modules\blog\forms;

use backend\modules\blog\entities\Post;
use backend\modules\blog\forms\PostForm;

class PostFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testPostEmpty()
    {
        $form = $this->generatePost(
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        expect_not($form->validate());

        expect_that($form->getErrors('title'));
        expect($form->getFirstError('title'))
            ->equals('Необходимо заполнить «Название поста».');

        expect_that($form->getErrors('alias'));
        expect($form->getFirstError('alias'))
            ->equals('Необходимо заполнить «Алиас».');

        expect_that($form->getErrors('category_id'));
        expect($form->getFirstError('category_id'))
            ->equals('Необходимо заполнить «Категория».');

//        expect_that($form->getErrors('published_at'));
//        expect($form->getFirstError('published_at'))
//            ->equals('Необходимо заполнить «Дата публикации».');

        expect_that($form->getErrors('content'));
        expect($form->getFirstError('content'))
            ->equals('Необходимо заполнить «Контент».');
    }

    private function generatePost(
        $category_id,
        $country_id,
        $author_id,
        $title,
        $alias,
        $description,
        $content,
        $media_id,
        $status,
        $published_at
    )
    {
        $post = Post::create(
            $category_id,
            $country_id,
            $author_id,
            $title,
            $alias,
            $description,
            $content,
            $media_id,
            $status,
            $published_at
        );

        return new PostForm($post);
    }
}