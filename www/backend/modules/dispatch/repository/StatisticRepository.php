<?php

namespace backend\modules\dispatch\repository;

use backend\modules\dispatch\entities\Statistic;

class StatisticRepository
{
    public function get($id): Statistic
    {
        if (!$static = Statistic::findOne($id)) {
            throw new \DomainException('Statistic is not found.');
        }
        return $static;
    }

    public function getByLetterId($letterId): Statistic
    {
        if (!$static = Statistic::findOne(['letter_id' => $letterId])) {
            throw new \DomainException('Statistic is not found.');
        }
        return $static;
    }

    public function save(Statistic $static): void
    {
        if (!$static->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Statistic $static): void
    {
        if (!$static->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}