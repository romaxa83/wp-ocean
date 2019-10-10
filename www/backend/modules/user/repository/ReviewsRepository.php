<?php

namespace backend\modules\user\repository;

use backend\modules\user\entities\Reviews;

class ReviewsRepository
{
    public function get($id): Reviews
    {
        if (!$reviews = Reviews::findOne($id)) {
            throw new \DomainException('Отзыв не найден.');
        }
        return $reviews;
    }

    public function save(Reviews $reviews): void
    {
        if (!$reviews->save()) {
            throw new \RuntimeException('Ошибка сохранения отзыва.');
        }
    }

    public function remove(Reviews $reviews): void
    {
        if (!$reviews->delete()) {
            throw new \RuntimeException('Ошибка удаления отзыва.');
        }
    }
}