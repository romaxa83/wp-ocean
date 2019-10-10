<?php

namespace backend\modules\dispatch\entities;

use backend\modules\dispatch\helpers\DateHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property boolean $status
 * @property int $send
 * @property int $created_at
 * @property int $updated_at
 */

class NewsLetter extends ActiveRecord
{
    const DRAFT = 0;
    const START_SEND = 1;
    const END_SEND = 2;

    public static function tableName()
    {
        return '{{%dispatch_letter}}';
    }

    public static function create($subject, $body, $send): self
    {
        $date = (new DateHelper())->nowTimestamp();

        $letter = new static();
        $letter->subject = $subject;
        $letter->body = $body;
        $letter->send = strtotime($send);
        $letter->status = self::DRAFT;
        $letter->created_at = $date;
        $letter->updated_at = $date;

        return $letter;
    }

    public function edit($subject,$body,$send)
    {
        $date = (new DateHelper())->nowTimestamp();

        $this->subject = $subject;
        $this->body = $body;
        $this->send = strtotime($send);
        $this->updated_at = $date;
    }

    public function status($status) : void
    {
        $date = (new DateHelper())->nowTimestamp();

        $this->status = (bool)$status;
        $this->updated_at = $date;
    }

    //Relation
    public function getStatistic(): ActiveQuery
    {
        return $this->hasOne(Statistic::class,['letter_id' => 'id']);
    }
}