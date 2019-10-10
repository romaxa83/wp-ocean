<?php

namespace backend\modules\dispatch\entities;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $dispatch_id
 * @property integer $letter_id
 */

class DispatchJob extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%dispatch_job}}';
    }

    //Relation
    public function getSubscriber(): ActiveQuery
    {
        return $this->hasOne(Subscriber::class, ['id' => 'dispatch_id']);
    }

    public function getLetter(): ActiveQuery
    {
        return $this->hasOne(NewsLetter::class, ['id' => 'letter_id']);
    }
}