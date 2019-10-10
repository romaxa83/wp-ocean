<?php

namespace backend\tests\unit\modules\user\entities;

use backend\modules\user\entities\Passport;
use backend\modules\user\events\PassportRejectScan;
use backend\modules\user\events\PassportVerify;
use backend\tests\fixtures\MediaFixture;
use backend\tests\fixtures\user\PassportFixture;
use backend\tests\fixtures\user\UserFixture;

class PassportTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /**
     * @var $passport Passport
     */
    private $passport;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ],
            'passport' => [
                'class' => PassportFixture::className()
            ],
            'media' => [
                'class' => MediaFixture::className()
            ]
        ]);

        $this->passport = $this->tester->grabFixture('passport', 3);
    }

    public function testCreateSuccess()
    {
        $passport = Passport::create(
            $first_name = 'Leopold',
            $last_name = 'Batters',
            $patronymic = 'Stoch',
            $birthday = '12/12/2000',
            $series = 'MO',
            $number = 1231231,
            $issued = 'South Park Department',
            $issued_date = '12/12/2010'
        );

        expect($passport->first_name)->equals($first_name);
        expect($passport->last_name)->equals($last_name);
        expect($passport->patronymic)->equals($patronymic);
        expect($passport->birthday)->notEquals($birthday);
        expect($passport->birthday)->equals('2000-12-12');
        expect($passport->series)->equals($series);
        expect($passport->number)->equals($number);
        expect($passport->issued)->equals($issued);
        expect($passport->issued_date)->notEquals($issued_date);
        expect($passport->issued_date)->equals('2010-12-12');
        expect($passport->media_id)->null();
        expect($passport->verify)->equals(Passport::PASSPORT_VERIFY_DRAFT);
        expect($passport->save())->true();
    }

    public function testSignUp()
    {
        $passport = Passport::createSignup(
            $first_name = 'Tom',
            $last_name = 'Hanks'
        );

        expect($passport->first_name)->equals($first_name);
        expect($passport->last_name)->equals($last_name);
        expect($passport->patronymic)->null();
        expect($passport->birthday)->null();
        expect($passport->series)->null();
        expect($passport->number)->null();
        expect($passport->issued)->null();
        expect($passport->issued_date)->null();
        expect($passport->media_id)->null();
        expect($passport->verify)->equals(Passport::PASSPORT_VERIFY_DRAFT);
        expect($passport->save())->true();
    }

    public function testEdit()
    {
        $passportOld = clone $this->passport;

        $dateInput = '12/12/2010';
        $dateSave = '2010-12-12';

        $this->passport->edit(
            $first_name = 'Tom',
            $last_name = 'Jerry',
            $patronymic = 'Nothing',
            $dateInput,
            $series = 'MO',
            $number = 1111111,
            $issued = 'Carton',
            $dateInput
        );

        expect($this->passport->first_name)->notEquals($passportOld->first_name);
        expect($this->passport->first_name)->equals($first_name);

        expect($this->passport->last_name)->notEquals($passportOld->last_name);
        expect($this->passport->last_name)->equals($last_name);

        expect($this->passport->patronymic)->notEquals($passportOld->patronymic);
        expect($this->passport->patronymic)->equals($patronymic);

        expect($this->passport->birthday)->notEquals($passportOld->birthday);
        expect($this->passport->birthday)->notEquals($dateInput);
        expect($this->passport->birthday)->equals($dateSave);

        expect($this->passport->series)->notEquals($passportOld->series);
        expect($this->passport->series)->equals($series);

        expect($this->passport->number)->notEquals($passportOld->number);
        expect($this->passport->number)->equals($number);

        expect($this->passport->issued)->notEquals($passportOld->issued);
        expect($this->passport->issued)->equals($issued);

        expect($this->passport->issued_date)->notEquals($passportOld->issued_date);
        expect($this->passport->issued_date)->notEquals($dateInput);
        expect($this->passport->issued_date)->equals($dateSave);

        expect($this->passport->verify)->equals($passportOld->verify);

        expect($this->passport->save())->true();
    }

    public function testVerify()
    {
        expect($this->passport->verify)->equals(Passport::PASSPORT_VERIFY_DRAFT);
        $this->passport->verify(Passport::PASSPORT_VERIFY_ACTIVE);
        expect($this->passport->verify)->equals(Passport::PASSPORT_VERIFY_ACTIVE);
        expect($this->passport->releaseEvents()[0] instanceof PassportVerify)->true();
    }

    public function testRejectScan()
    {
        expect($this->passport->media_id)->notNull();
        $this->passport->rejectScan();
        expect($this->passport->media_id)->null();
        expect($this->passport->releaseEvents()[0] instanceof PassportRejectScan)->true();
    }

    public function testGetMedia()
    {
        $media = $this->tester->grabFixture('media', $this->passport->media_id);
        expect($this->passport->media->filename)->equals($media->filename);
    }
}