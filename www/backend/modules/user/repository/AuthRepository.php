<?php

namespace backend\modules\user\repository;

use common\models\Auth;

class AuthRepository
{
    public function get($source,$source_id)
    {
        $auth = Auth::find()->where([
            'source' => $source,
            'source_id' => $source_id,
        ])->one();
//        if (!$auth) {
//            throw new \DomainException('Запись по авторизации пользователя,через соц.сеть не найдена.');
//        }

        return $auth;
    }

    public function save(Auth $auth): void
    {
        if (!$auth->save()) {
            throw new \RuntimeException('Ошибка сохранения пользователя.');
        }
    }

    public function remove(Auth $auth): void
    {
        if (!$auth->delete()) {
            throw new \RuntimeException('Ошибка удаления пользователя.');
        }
    }
}