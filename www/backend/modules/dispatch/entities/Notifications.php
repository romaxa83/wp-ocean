<?php

namespace backend\modules\dispatch\entities;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $text
 * @property string $variables
 * @property boolean $status
 * @property int $created_at
 * @property int $updated_at
 */

class Notifications extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName()
    {
        return '{{%dispatch_notifications}}';
    }

    public function edit($text,$name)
    {
        $this->text = $text;
        $this->name = $name;
        $this->updated_at = time();
    }

    public function status($status) : void
    {
        $this->status = $status;
        $this->updated_at = time();
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE ? true : false;
    }

}