<?php

namespace backend\tests\unit\modules\forms;

use backend\modules\user\forms\UserEditForm;
use backend\tests\fixtures\user\UserFixture;

class UserEditFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([

            'user' => [
                'class' => UserFixture::className()
            ]
        ]);
    }

    public function testEmptyValue()
    {
        $data = [];
        $form = $this->generateUserEditForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Необходимо заполнить «Email».');

        expect_that($form->getErrors('phone'));
        expect($form->getFirstError('phone'))
            ->equals('Необходимо заполнить «Телефон».');
    }

    public function testExistEmail()
    {
        $user = $this->tester->grabFixture('user', 1);
        $data = [
            'email' => $user->email,
            'phone' => '+3(097)-774-4747',
        ];
        $form = $this->generateUserEditForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Пользователь с такой почтой уже зарегистрирован');
    }

    public function testExistPhone()
    {
        $user = $this->tester->grabFixture('user', 1);
        $data = [
            'email' => 'test@test.com',
            'phone' => $user->phone,
        ];
        $form = $this->generateUserEditForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('phone'));
        expect($form->getFirstError('phone'))
            ->equals('Пользователь с таким номером телефоном уже зарегистрирован');
    }


    public function testSuccess()
    {
        $data = [
            'email' => 'test@test.com',
            'phone' => '+3(097)-774-4747'
        ];
        $form = $this->generateUserEditForm($data);

        expect_that($form->validate());
    }

    private function generateUserEditForm($array)
    {
        $user = $this->tester->grabFixture('user', 3);
        $form = new UserEditForm($user);

        $form->email = $array['email']??null;
        $form->phone = $array['phone']??null;

        return $form;
    }

}