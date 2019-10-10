<?php

namespace backend\tests\unit\modules\forms;

use backend\modules\user\forms\PasswordForm;
use backend\tests\fixtures\user\UserFixture;

class PasswordFormTest extends \Codeception\Test\Unit
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
        $form = $this->generatePasswordForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))
            ->equals('Необходимо заполнить «Пароль».');

        expect_that($form->getErrors('password_new'));
        expect($form->getFirstError('password_new'))
            ->equals('Необходимо заполнить «Новый пароль».');

        expect_that($form->getErrors('password_confirm'));
        expect($form->getFirstError('password_confirm'))
            ->equals('Необходимо заполнить «Потверждения пароля».');
    }

    public function testWrongPassword()
    {
        $data = [
            'password' => 'wrongPassword',
            'password_new' => 'new_password',
            'password_confirm' => 'new_password'
        ];
        $form = $this->generatePasswordForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))
            ->equals('Добрый человек, пароль неверный ¯\_(ツ)_/¯');
    }

    public function testShortNewPassword()
    {
        $data = [
            'password' => 'romaxa',
            'password_new' => 'new',
            'password_confirm' => 'new'
        ];
        $form = $this->generatePasswordForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('password_new'));
        expect($form->getFirstError('password_new'))
            ->equals('Значение «Новый пароль» должно содержать минимум 4 символа.');
    }

    public function testWrongSymbolsInPassword()
    {
        $data = [
            'password' => 'romaxa',
            'password_new' => 'пароль',
            'password_confirm' => 'пароль'
        ];
        $form = $this->generatePasswordForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('password_new'));
        expect($form->getFirstError('password_new'))
            ->equals('Пароль должен состоять из английских символов и цифр и быть длинее 4 знаков');
    }

    public function testNotConfirmNewPassword()
    {
        $data = [
            'password' => 'romaxa',
            'password_new' => 'password',
            'password_confirm' => 'passwords'
        ];
        $form = $this->generatePasswordForm($data);

        expect_not($form->validate());

        expect_that($form->getErrors('password_confirm'));
        expect($form->getFirstError('password_confirm'))
            ->equals('Пароли не совпадают');
    }

    public function testSuccess()
    {
        $data = [
            'password' => 'romaxa',
            'password_new' => 'password',
            'password_confirm' => 'password'
        ];
        $form = $this->generatePasswordForm($data);

        expect_that($form->validate());
    }

    private function generatePasswordForm($array)
    {
        $user = $this->tester->grabFixture('user', 3);
        $form = new PasswordForm($user->id);

        $form->password = $array['password']??null;
        $form->password_new = $array['password_new']??null;
        $form->password_confirm = $array['password_confirm']??null;

        return $form;
    }

}