<?php

namespace backend\modules\dispatch\repository;

use backend\modules\dispatch\entities\Subscriber;

class SubscriberRepository
{
    public function get($id): Subscriber
    {
        if (!$subscriber = Subscriber::findOne($id)) {
            throw new \DomainException('Subscriber is not found.');
        }
        return $subscriber;
    }

    public function getAllActive()
    {
        if (!$subscribers = Subscriber::findAll(['status' => Subscriber::STATUS_ON])) {
            throw new \DomainException('Активных подписчиков не найдено');
        }
        return $subscribers;
    }

    public function getByUserId($user_id)
    {
        if (!$subscriber = Subscriber::findOne(['user_id' => $user_id])) {
            return false;
        }
        return $subscriber;
    }

    public function save(Subscriber $subscriber): void
    {
        if (!$subscriber->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Subscriber $subscriber): void
    {
        if (!$subscriber->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}