<?php

namespace backend\modules\user\entities;

use backend\modules\user\helpers\DateFormat;
use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use backend\modules\referenceBooks\models\Hotel;
use yii\helpers\Html;

/**
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $user_id
 * @property string $text
 * @property integer $status
 * @property integer $rating
 * @property integer $from_date
 * @property integer $to_date
 * @property integer $created_at
 * @property integer $updated_at
 */

class Reviews extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    public static function tableName(): string
    {
        return '{{%user_reviews}}';
    }

    public static function create(
        $user_id,
        $hotel_id,
        $text,
        $rating,
        $from_date,
        $to_date
    ) : self
    {
        $review = new static();
        $review->user_id = $user_id;
        $review->hotel_id = $hotel_id;
        $review->text = Html::encode(strip_tags($text));
        $review->rating = $rating;
        $review->from_date = DateFormat::convertTimestamp($from_date);
        $review->to_date = DateFormat::convertTimestamp($to_date);
        $review->created_at = time();
        $review->updated_at = time();

        return $review;
    }

    public function edit($text) :void
    {
        $this->text = Html::encode(strip_tags($text));
        $this->updated_at = time();
    }

    public function status($status):void
    {
        $this->status = $status;
        $this->updated_at = time();
    }

    //Relation
    public function getHotel(): ActiveQuery
    {
        return $this->hasOne(Hotel::class, ['id' => 'hotel_id']);
    }
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getPassport(): ActiveQuery
    {
        return $this->hasOne(Passport::class, ['id' => 'passport_id'])->via('user');
    }
}