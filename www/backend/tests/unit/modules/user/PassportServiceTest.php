<?php

namespace backend\tests\unit\modules\user;

use backend\modules\user\entities\Passport;
use backend\tests\fixtures\user\PassportFixture;
use backend\modules\user\services\PassportService;
use backend\modules\user\repository\PassportRepository;

class PassportServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /**
     * @var $passportService PassportService
     */
    private $passportService;

    /**
     * @var $passport Passport
     */
    private $passport;

    public function _before()
    {
        $this->tester->haveFixtures([
            'passport' => [
                'class' => PassportFixture::className()
            ]
        ]);

        $this->passportService = new PassportService(
            new PassportRepository()
        );

        $this->passport = $this->tester->grabFixture('passport', 1);
    }

    public function _after()
    {
        Passport::deleteAll();
    }

    public function testVerify()
    {
        expect($this->passport->verify)->equals(Passport::PASSPORT_VERIFY_DRAFT);

        $passportEdit = $this->passportService->verify($this->passport->id,Passport::PASSPORT_VERIFY_DRAFT);

        expect($passportEdit->id)->equals($this->passport->id);
        expect($passportEdit->verify)->equals(Passport::PASSPORT_VERIFY_ACTIVE);
    }
}