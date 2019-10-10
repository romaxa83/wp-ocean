<?php

namespace backend\modules\user\entities;

use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use backend\modules\user\helpers\DateFormat;
use backend\modules\referenceBooks\models\Country;


/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property string $with
 * @property string $to
 * @property integer $persons
 * @property integer $status
 * @property integer $type_send
 * @property integer $created
 */

class SmartMailing extends ActiveRecord
{

    const STATUS_SEARCH = 0;
    const STATUS_FOUND = 1;

    const TYPE_NOTHING = 0;
    const TYPE_EMAIL = 1;
    const TYPE_TELEGRAM = 2;
    const TYPE_VIBER = 3;


    public static function tableName(): string
    {
        return '{{%user_smart_mailing}}';
    }

    public static function create(
        $user_id,
        $country_id,
        $with,
        $to,
        $persons
    ) : self
    {
        $mailing = new static();
        $mailing->user_id = $user_id;
        $mailing->country_id = $country_id;
        $mailing->with = DateFormat::forSave($with);
        $mailing->to = DateFormat::forSave($to);
        $mailing->persons = $persons;
        $mailing->created = time();

        return $mailing;
    }

    //Relation
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}