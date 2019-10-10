<?php

namespace backend\modules\user\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $user_id
 * @property integer $passport_int_id
 */
class PassportAssignment extends ActiveRecord
{
    public static function create($user_id) : self
    {
        $assignment = new static();
        $assignment->user_id = $user_id;

        return $assignment;
    }

    public static function tableName() : string
    {
        return '{{%user_passport_assignments}}';
    }
}