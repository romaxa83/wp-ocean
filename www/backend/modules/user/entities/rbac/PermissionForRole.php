<?php

namespace backend\modules\user\entities\rbac;

use yii\db\ActiveRecord;

/**
 * @property string $parent
 * @property string $child
 */

class PermissionForRole extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%auth_item_child}}';
    }
}