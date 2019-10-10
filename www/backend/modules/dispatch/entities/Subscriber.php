<?php

namespace backend\modules\dispatch\entities;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $email
 * @property boolean $status
 * @property int $created_at
 */

class Subscriber extends ActiveRecord
{
    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    public static function tableName()
    {
        return '{{%dispatch}}';
    }

    public static function create($user_id, $email,$status = null): self
    {
        $subscriber = new static();
        $subscriber->user_id = $user_id;
        $subscriber->email = $email;
        $subscriber->status = $status !== null ? (bool)$status :self::STATUS_ON;
        $subscriber->created_at = time();

        return $subscriber;
    }

    public function status($status) : void
    {
        $this->status = (bool)$status;
    }

    //Relation
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}