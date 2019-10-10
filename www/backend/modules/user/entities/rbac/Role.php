<?php

namespace backend\modules\user\entities\rbac;

use yii\db\ActiveRecord;

/**
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property integer $rule_name
 * @property integer $data
 * @property integer $created_at
 * @property integer $updated_at
 */

class Role extends ActiveRecord
{
    const ROLE = 1;
    const PERMISSION = 2;

    public static function tableName(): string
    {
        return '{{%auth_item}}';
    }

    public static function findByName($name)
    {
        return self::find()->where(['name' => $name])->one();
    }
}