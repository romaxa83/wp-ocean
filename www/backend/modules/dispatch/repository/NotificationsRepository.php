<?php

namespace backend\modules\dispatch\repository;

use backend\modules\dispatch\entities\Notifications;

class NotificationsRepository
{
    public function get($id): Notifications
    {
        if (!$notification = Notifications::findOne($id)) {
            throw new \DomainException('Notifications is not found.');
        }
        return $notification;
    }

    public function getByAlias($alias): ? Notifications
    {
        if (!$notification = Notifications::findOne(['alias' => $alias])) {
            throw new \DomainException('Notifications is not found by alias.');
        }
        return $notification;
    }

    public function save(Notifications $notifications): void
    {
        if (!$notifications->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Notifications $notifications): void
    {
        if (!$notifications->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}