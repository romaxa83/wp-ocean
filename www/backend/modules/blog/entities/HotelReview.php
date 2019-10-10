<?php

namespace backend\modules\blog\entities;

use backend\modules\blog\helpers\DateHelper;
use backend\modules\blog\helpers\ImageHelper;
use backend\modules\referenceBooks\models\Hotel;
use Carbon\Carbon;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $seo_id
 * @property string $title
 * @property string $alias
 * @property string $description
 * @property string $content
 * @property string $media_ids
 * @property integer $views
 * @property integer $likes
 * @property integer $links
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 */

class HotelReview extends ActiveRecord
{
    const INACTIVE = 0;
    const ACTIVE = 1;
    const DRAFT = 2;


    public static function tableName(): string
    {
        return '{{%blog_hotel_review}}';
    }

    public static function create(
        $hotel_id,
        $title,
        $alias,
        $description,
        $content,
        $media_ids,
        $status,
        $published_at): self
    {
        $post = new static();
        $post->hotel_id = $hotel_id;
        $post->title = $title;
        $post->alias = $alias;
        $post->description = $description;
        $post->content = $content;
        $post->media_ids = $media_ids;
        $post->status = self::setStatus((int)$status,strtotime($published_at));
        $post->published_at = strtotime($published_at);
        $post->created_at = time();
        $post->updated_at = time();

        return $post;
    }

    public function edit(
        $hotel_id,
        $title,
        $alias,
        $description,
        $content,
        $media_ids,
        $status,
        $published_at): void
    {
        $this->hotel_id = $hotel_id;
        $this->title = $title;
        $this->alias = $alias;
        $this->description = $description;
        $this->content = $content;
        $this->media_ids = $media_ids;
        $this->status = self::setStatus((int)$status,DateHelper::convertPublishedForUnix($published_at));
        $this->published_at = DateHelper::convertPublishedForUnix($published_at);
        $this->updated_at = time();

    }

    /**
     * @param $status
     */
    public function status($status):void
    {
        $this->status = $status;
        $this->published_at = time();
        $this->updated_at = time();
    }

    public function removeMediaId($media_id)
    {
        $arr = array_filter(ImageHelper::parseMediaIds($this->media_ids),function ($item) use ($media_id){
            return $item != $media_id;
        });

        $this->media_ids =  '[' . implode(',',$arr) . ']';
        $this->updated_at = time();
    }

    public function addView():void
    {
        $this->views += 1;
        $this->updated_at = time();
    }

    public function addMedia($media_ids)
    {
        $this->media_ids =  '[' . implode(',',$media_ids) . ']';
        $this->updated_at = time();
    }

    /**
     * @param $seo_id
     */
    public function addSeo($seo_id) :void
    {
        $this->seo_id = $seo_id;
    }
    //Relation

    /**
     * @return ActiveQuery
     */
    public function getHotel(): ActiveQuery
    {
        return $this->hasOne(Hotel::class, ['id' => 'hotel_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSeo(): ActiveQuery
    {
        return $this->hasOne(Meta::class, ['page_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getTagReviewAssignments(): ActiveQuery
    {
        return $this->hasMany(TagReviewAssignment::class, ['hotel_review_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagReviewAssignments');
    }

    public static function setStatus($status,$published_at)
    {
        if($status == self::ACTIVE && $published_at > (Carbon::now())->add(10,'min')->timestamp){
            return self::DRAFT;
        }

        if($status == self::DRAFT && $published_at < (Carbon::now())->add(10,'min')->timestamp){
            return self::ACTIVE;
        }
        return $status;
    }

}