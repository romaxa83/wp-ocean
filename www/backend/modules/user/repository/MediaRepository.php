<?php

namespace backend\modules\user\repository;

use backend\modules\filemanager\models\Mediafile;

class MediaRepository
{
    public function get($id): Mediafile
    {
        if (!$image = Mediafile::findOne($id)) {
            throw new \DomainException('Аватар пользователя не найден.');
        }
        return $image;
    }

    public function save(Mediafile $image): void
    {
        if (!$image->save()) {
            throw new \RuntimeException('Ошибка сохранения аватарки пользователя.');
        }
    }
}