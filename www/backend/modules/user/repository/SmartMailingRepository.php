<?php

namespace backend\modules\user\repository;

use backend\modules\user\entities\SmartMailing;

class SmartMailingRepository
{
    public function get($id): SmartMailing
    {
        if (!$smart = SmartMailing::findOne($id)) {
            throw new \DomainException('Подписка пользователя не найден.');
        }
        return $smart;
    }

    public function getAll($user_id)
    {
        return SmartMailing::find()->where(['user_id' => $user_id])->orderBy(['id' => SORT_DESC])->all();
    }

    public function save(SmartMailing $smart): void
    {
        if (!$smart->save()) {
            throw new \RuntimeException('Ошибка сохранения подписки пользователя.');
        }
    }

    public function remove(SmartMailing $smart): void
    {
        if (!$smart->delete()) {
            throw new \RuntimeException('Ошибка удаления подписки пользователя.');
        }
    }

    public function removeAll($user_id): void
    {
        SmartMailing::deleteAll(['user_id' => $user_id]);
    }
}