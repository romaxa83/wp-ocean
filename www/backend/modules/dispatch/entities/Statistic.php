<?php

namespace backend\modules\dispatch\entities;

use backend\modules\dispatch\helpers\DateHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $letter_id
 * @property integer $all
 * @property integer $sended
 * @property integer $start_time
 * @property integer $end_time
 */

class Statistic extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%dispatch_statistic}}';
    }

    public static function create($letter_id, $all): self
    {
        $date = (new DateHelper())->nowTimestamp();

        $statistic = new static();
        $statistic->letter_id = $letter_id;
        $statistic->all = $all;
        $statistic->sended = 0;
        $statistic->start_time = $date;

        return $statistic;
    }

    //Relation

    public function getLetter(): ActiveQuery
    {
        return $this->hasOne(NewsLetter::class, ['id' => 'letter_id']);
    }
}