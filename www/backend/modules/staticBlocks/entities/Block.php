<?php

namespace backend\modules\staticBlocks\entities;

use backend\modules\filemanager\models\Mediafile;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $block
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property boolean $status
 * @property boolean $status_block
 * @property int $position
 */

class Block extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATUS_BLOCK_ACTIVE = 1;
    const STATUS_BLOCK_INACTIVE = 0;

    public static function tableName()
    {
        return '{{%static_block}}';
    }

    public static function create($title,$alias,$description,$position,$block) : self
    {
        $seo = new static();
        $seo->title = $title;
        $seo->alias = $alias;
        $seo->description = $description;
        $seo->position = $position;
        $seo->block = $block;
        $seo->status = self::STATUS_ACTIVE;
        $seo->status_block = self::STATUS_BLOCK_ACTIVE;

        return $seo;
    }

    public function status($status) : void
    {
        $this->status = $status;
    }

    public function edit($title,$alias,$description,$position) : void
    {
        $this->title = $title;
        $this->alias = $alias;
        $this->description = $description;
        $this->position = $position;
    }

    public function changePosition($position) : void
    {
        $this->position = $position;
    }

    //Relation
    public function getPreview(): ActiveQuery
    {
        return $this->hasOne(Mediafile::class, ['id' => 'title']);
    }

    public function getVideo(): ActiveQuery
    {
        return $this->hasOne(Mediafile::class, ['id' => 'description']);
    }
}
