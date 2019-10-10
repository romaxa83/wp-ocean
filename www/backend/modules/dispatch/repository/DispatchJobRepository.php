<?php

namespace backend\modules\dispatch\repository;

use backend\modules\dispatch\entities\NewsLetter;

class DispatchJobRepository
{
    public function save(NewsLetter $news): void
    {
        if (!$news->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function saveAll($subscriber_ids,$letter_id): void
    {
        \Yii::$app->db->createCommand()->batchInsert(
            '{{%dispatch_job}}',['dispatch_id','letter_id'],
            array_map(function($item) use ($letter_id) {
                return [
                    'dispatch_id' => $item,
                    'letter_id' => $letter_id,
                ];
            },$subscriber_ids)
        )->execute();
    }
}