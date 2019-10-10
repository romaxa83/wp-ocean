<?php

namespace backend\modules\user\entities;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use backend\modules\user\events\EventTrait;
use backend\modules\user\helpers\DateFormat;
use backend\modules\user\events\PassportVerify;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\user\events\PassportRejectScan;

/**
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $birthday
 * @property string $series
 * @property integer $number
 * @property string $issued
 * @property string $issued_date
 * @property integer $verify
 * @property integer $media_id
 */

class Passport extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    const VERIFY_ON = 1;
    const VERIFY_OFF = 0;

    const PASSPORT_VERIFY_ACTIVE = 1;
    const PASSPORT_VERIFY_DRAFT = 0;

    public static function tableName(): string
    {
        return '{{%user_passport}}';
    }

    public static function create(
        $first_name,
        $last_name,
        $patronymic,
        $birthday,
        $series,
        $number,
        $issued,
        $issued_date
    ) : self
    {
        $passport = new static();
        $passport->first_name = self::valid($first_name);
        $passport->last_name = self::valid($last_name);
        $passport->patronymic = self::valid($patronymic);
        $passport->birthday = self::valid($birthday ? DateFormat::forSave($birthday) : null);
        $passport->series = self::valid(strtoupper($series));
        $passport->number = self::valid($number);
        $passport->issued = self::valid($issued);
        $passport->issued_date = self::valid($issued_date !== null ? DateFormat::forSave($issued_date) : null);

        return $passport;
    }

    public static function createSignup(
        $first_name,
        $last_name
    ) : self
    {
        $passport = new static();
        $passport->first_name = $first_name;
        $passport->last_name = $last_name;

        return $passport;
    }

    public function edit(
        $first_name,
        $last_name,
        $patronymic,
        $birthday,
        $series,
        $number,
        $issued,
        $issued_date,
        $media_id = null
    ) : void
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->patronymic = $patronymic;
        $this->birthday = DateFormat::forSave($birthday);
        $this->series = $series;
        $this->number = $number;
        $this->issued = $issued;
        $this->issued_date = DateFormat::forSave($issued_date);
        if($media_id){
            $this->media_id = $media_id;
        }
    }

    public function verify($verify):void
    {
        $this->verify = (bool)$verify;
        if($verify){
            $this->recordEvent(new PassportVerify($this));
        } else {
            $this->recordEvent(new PassportRejectScan($this));
        }
    }

    public function rejectScan():void
    {
        $this->media_id = null;
        $this->recordEvent(new PassportRejectScan($this));
    }

    //Relation
    public function getMedia(): ActiveQuery
    {
        return $this->hasOne(Mediafile::class, ['id' => 'media_id']);
    }
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['passport_id' => 'id']);
    }

    private static function valid($data)
    {
        return $data != ''?$data:null;
    }
}