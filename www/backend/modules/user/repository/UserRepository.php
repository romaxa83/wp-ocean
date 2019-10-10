<?php

namespace backend\modules\user\repository;

use common\models\User;

class UserRepository
{
    public function get($id): User
    {
        if (!$user = User::findOne($id)) {
            throw new \DomainException('Пользователь не найден.');
        }
        return $user;
    }

    public function save(User $user): User
    {
        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения пользователя.');
        }
        return $user;
    }

    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Ошибка удаления пользователя.');
        }
    }

    public function getByConfirmToken($token)
    {
        if (empty($token)) {
            throw new \DomainException('Пользователь не найден.');
        }
        return User::findOne([
            'confirm_token' => $token,
            'status' => User::STATUS_DRAFT,
        ]);
    }
}