<?php

namespace backend\modules\user\repository;

use backend\modules\user\entities\IntPassport;

class IntPassportRepository
{
    public function get($id): IntPassport
    {
        if (!$passport = IntPassport::findOne($id)) {
            throw new \DomainException('Загранпаспорт пользователя не найден.');
        }
        return $passport;
    }

    public function save(IntPassport $passport): void
    {
        if (!$passport->save()) {
            throw new \RuntimeException('Ошибка сохранения загранпаспорта пользователя.');
        }
    }

    public function remove(IntPassport $passport): void
    {
        if (!$passport->delete()) {
            throw new \RuntimeException('Ошибка удаления паспорта пользователя.');
        }
    }

    public function removeAll($ids): void
    {
        IntPassport::deleteAll(['id' => $ids]);
    }
}