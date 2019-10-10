<?php

namespace backend\tests\unit\forms;

use backend\tests\fixtures\user\UserFixture;
use frontend\models\PasswordResetRequestForm;

class PasswordResetRequestFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /* подгрузка пользователей в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ]
        ]);
    }

    /* проверка на ввод пустых значений */
    public function testEmailEmpty()
    {
        $form = $this->generateData(null);

        expect_not($form->validate());
        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Необходимо заполнить «Email».');
    }

    /* проверка на не корректный email */
    public function testEmailWrong()
    {
        $form = $this->generateData('werewrwerwe');

        expect_not($form->validate());
        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Значение «Email» не является правильным email адресом.');
    }

    /* проверка на существование пользователя с таким email */
    public function testEmailExist()
    {
        $form = $this->generateData('test@test.com');

        expect_not($form->validate());
        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Пользователь с такой почтой не зарегистрирован');
    }

    /* проверка на верный email */
    public function testEmailSuccess()
    {
        $form = $this->generateData('unique@gmail.com');

        expect_that($form->validate());
    }

    /* генерация тестовых данных при збросе пароля */
    private function generateData($email)
    {
        return new PasswordResetRequestForm([
            'email' => $email,
        ]);
    }

}