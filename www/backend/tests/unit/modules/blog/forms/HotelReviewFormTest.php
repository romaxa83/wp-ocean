<?php

namespace backend\tests\unit\modules\blog\forms;

use backend\modules\blog\entities\HotelReview;
use backend\modules\blog\forms\HotelReviewForm;

class HotelReviewFormTest extends \Codeception\Test\Unit
{
    /* проверка на ввод пустых значений */
    public function testPostEmpty()
    {
        $form = $this->generateHotelReview(
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
            ->equals('Необходимо заполнить «Название обзора».');

        expect_that($form->getErrors('alias'));
        expect($form->getFirstError('alias'))
            ->equals('Необходимо заполнить «Алиас».');

        expect_that($form->getErrors('hotel_id'));
        expect($form->getFirstError('hotel_id'))
            ->equals('Необходимо заполнить «Отель».');

//        expect_that($form->getErrors('published_at'));
//        expect($form->getFirstError('published_at'))
//            ->equals('Необходимо заполнить «Дата публикации».');

        expect_that($form->getErrors('content'));
        expect($form->getFirstError('content'))
            ->equals('Необходимо заполнить «Контент».');
    }

    private function generateHotelReview(
        $hotel_id,
        $title,
        $alias,
        $description,
        $content,
        $media_ids,
        $status,
        $published_at
    )
    {
        $hotelReview = HotelReview::create(
            $hotel_id,
            $title,
            $alias,
            $description,
            $content,
            $media_ids,
            $status,
            $published_at
        );

        return new HotelReviewForm($hotelReview);
    }
}