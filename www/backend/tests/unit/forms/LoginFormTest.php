<?php

namespace backend\tests\unit\forms;

use common\models\LoginForm;
use backend\tests\fixtures\user\UserFixture;

class LoginFormTest extends \Codeception\Test\Unit
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
    public function testLoginEmpty()
    {
        $form = $this->generateData(null,null);

        expect_not($form->validate());

        expect_that($form->getErrors('email'));
        expect_that($form->getErrors('password'));

        expect($form->getFirstError('email'))
            ->equals('Необходимо заполнить «Email».');

        expect($form->getFirstError('password'))
            ->equals('Необходимо заполнить «Пароль».');
    }

    /* проверка на корректный email */
    public function testCorrectEmail()
    {
        $form = $this->generateData('wrongemail','password');

        expect_not($form->validate());
        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Значение «Email» не является правильным email адресом.');
    }

    /* проверка на существование пользователя с таким email */
    public function testExistEmail()
    {
        $form = $this->generateData('anyemail@gmail.com','password');

        expect_not($form->validate());
        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))
            ->equals('Пользователь с такой почтой не зарегистрирован');
    }

    /* проверка правильности пароля */
    public function testCorrectPassword()
    {
        $form = $this->generateData('unique@gmail.com','password1');

        expect_not($form->validate());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))
            ->equals('Введеный пароль не соответствует данной почте');
    }

    /* проверка на успешный логин */
    public function testLoginSuccess()
    {
        $form = $this->generateData('unique@gmail.com','romaxa');

        expect_that($form->validate());
        expect($form->login())->true();
        expect(\Yii::$app->user->isGuest)->false();
    }

    /* генерация тестовых данных при логине */
    private function generateData($email,$password)
    {
        return new LoginForm([
            'email' => $email,
            'password' => $password,
        ]);
    }

}