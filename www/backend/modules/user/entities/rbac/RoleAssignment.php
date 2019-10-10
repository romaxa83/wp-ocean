<?php

namespace backend\modules\user\entities\rbac;

use yii\db\ActiveRecord;

/**
 * @property string $item_name
 * @property integer $user_id
 * @property integer $created_at
 */

class RoleAssignment extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%auth_assignment}}';
    }
}