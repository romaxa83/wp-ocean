<?php

namespace backend\modules\user\repository;

use backend\modules\user\entities\Passport;

class PassportRepository
{
    public function get($id): Passport
    {
        if (!$passport = Passport::findOne($id)) {
            throw new \DomainException('Паспорт пользователя не найден.');
        }
        return $passport;
    }

    public function save(Passport $passport): void
    {
        if (!$passport->save()) {
            throw new \RuntimeException('Ошибка сохранения паспорта пользователя.');
        }
    }

    public function remove(Passport $passport): void
    {
        if (!$passport->delete()) {
            throw new \RuntimeException('Ошибка удаления паспорта пользователя.');
        }
    }
}