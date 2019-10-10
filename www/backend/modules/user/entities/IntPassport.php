<?php

namespace backend\modules\user\entities;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use backend\modules\user\events\EventTrait;
use backend\modules\user\helpers\DateFormat;
use backend\modules\filemanager\models\Mediafile;
use backend\modules\user\events\PassportIntRejectScan;

/**
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property integer $sex
 * @property string $birthday
 * @property string $series
 * @property integer $number
 * @property string $issued
 * @property string $issued_date
 * @property string $expired_date
 * @property integer $verify
 * @property integer $media_id
 */

class IntPassport extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    const VERIFY_ON = 1;
    const VERIFY_OFF = 0;

    const PASSPORT_VERIFY_ACTIVE = 1;
    const PASSPORT_VERIFY_DRAFT = 0;

    const MAN = 1;
    const WOMAN = 2;
    const CHILD = 3;
    const BABY = 4;

    public static function tableName(): string
    {
        return '{{%user_int_passport}}';
    }

    public static function create(
        $first_name,
        $last_name,
        $sex,
        $birthday,
        $series,
        $number,
        $issued,
        $issued_date,
        $expired_date,
        $media_id
    ) : self
    {
        $passport = new static();
        $passport->first_name = $first_name;
        $passport->last_name = $last_name;
        $passport->sex = $sex;
        $passport->birthday = $birthday ? DateFormat::forSave($birthday) : null;
        $passport->series = strtoupper($series);
        $passport->number = $number;
        $passport->issued = $issued;
        $passport->issued_date = $issued_date !== null ? DateFormat::forSave($issued_date) : null;
        $passport->expired_date = $expired_date !== null ? DateFormat::forSave($expired_date) : null;
        $passport->media_id = $media_id;

        return $passport;
    }

    public function edit(
        $first_name,
        $last_name,
        $sex,
        $birthday,
        $series,
        $number,
        $issued,
        $issued_date,
        $expired_date
    ) : void
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->sex = $sex;
        $this->birthday = DateFormat::forSave($birthday);
        $this->series = $series;
        $this->number = $number;
        $this->issued = $issued;
        $this->issued_date = DateFormat::forSave($issued_date);
        $this->expired_date = DateFormat::forSave($expired_date);
    }

    public function verify($verify):void
    {
        $this->verify = (bool)$verify;
    }

    public function rejectScan():void
    {
        $this->media_id = null;
        $this->recordEvent(new PassportIntRejectScan($this));
    }

    //Relation
    public function getMedia(): ActiveQuery
    {
        return $this->hasOne(Mediafile::class, ['id' => 'media_id']);
    }

    public function getPassportAssignments(): ActiveQuery
    {
        return $this->hasMany(PassportAssignment::class, ['passport_int_id' => 'id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->via('passportAssignments');
    }
}