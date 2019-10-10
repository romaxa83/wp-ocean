<?php

namespace backend\tests\unit\modules\user\entities;

use common\models\User;
use backend\tests\fixtures\CountryFixture;
use backend\modules\user\helpers\DateFormat;
use backend\tests\fixtures\user\UserFixture;
use backend\modules\user\entities\SmartMailing;
use backend\modules\referenceBooks\models\Country;

class SmartMailingTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /**
     * @var $country Country
     */
    private $country;

    /**
     * @var $user User
     */
    private $user;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ],
            'country' => [
                'class' => CountryFixture::className()
            ]
        ]);

        $this->user = $this->tester->grabFixture('user',3);

        $this->country = $this->tester->grabFixture('country', 1);
    }

    public function testCreateSuccess()
    {
        $smart = SmartMailing::create(
            $this->user->id,
            $this->country->id,
            $with = '12/12/2000',
            $to ='20/12/2000',
            $person = 1
        );

        expect($smart->user->email)->equals($this->user->email);
        expect($smart->country->name)->equals($this->country->name);
        expect($smart->with)->notEquals($with);
        expect($smart->with)->equals(DateFormat::forSave($with));
        expect($smart->to)->notEquals($to);
        expect($smart->to)->equals(DateFormat::forSave($to));
        expect($smart->persons)->equals($person);
        expect($smart->status)->equals(SmartMailing::STATUS_SEARCH);
        expect($smart->save())->true();
    }
}