<?php

namespace backend\tests\unit\forms;

use common\models\SignupForm;
use backend\tests\fixtures\user\UserFixture;
use backend\modules\user\forms\PassportSignupForm;

class SignUpFormTest extends \Codeception\Test\Unit
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

    /* проверка при корректном заполнение */
    public function testSignUpSuccess()
    {
        $form = $this->generateData(
            'test',
            'test',
            'test@test.com',
            '+38(095)-111-1111',
            'password',
            'password',
            '1');

        expect_that($form->validate());
    }

    /* проверка на ввод пустых значений */
    public function testSignUpEmpty()
    {
        $form = $this->generateData(null,null,null,null,null,null,'0');

        expect_not($form->validate());

        expect_that($form->getErrors('email'));
        expect_that($form->getErrors('phone'));
        expect_that($form->getErrors('password'));
        expect_that($form->getErrors('password_confirm'));
        expect_that($form->passport->getErrors('first_name'));
        expect_that($form->passport->getErrors('last_name'));

        expect($form->getFirstError('email'))
            ->equals('Необходимо заполнить «Email».');

        expect($form->getFirstError('phone'))
            ->equals('Необходимо заполнить «Телефон».');

        expect($form->getFirstError('password'))
            ->equals('Необходимо заполнить «Пароль».');

        expect($form->getFirstError('password_confirm'))
            ->equals('Необходимо заполнить «Потверждение пароль».');

        expect($form->passport->getFirstError('first_name'))
            ->equals('Необходимо заполнить «Имя».');

        expect($form->passport->getFirstError('last_name'))
            ->equals('Необходимо заполнить «Фамилия».');
    }

    /* проверка на совпадение паролей */
    public function testWrongConfirmPassword()
    {
        $form = $this->generateData(
            'test',
            'test',
            'test@test.com',
            '+38(095)-111-1111',
            'password',
            'password1',
            '1');

        expect_not($form->validate());
        expect_that($form->getErrors('password_confirm'));
        expect($form->getFirstError('password_confirm'))->equals('Пароли не совпадают');
    }

    /* проверка на корректный пароль */
    public function testCorrectPassword()
    {
        $form = $this->generateData(
            'test',
            'test',
            'test@gmail.com',
            '+38(121)-111-1111',
            'вапвапвапва',
            'password',
            '1');

        expect_not($form->validate());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))->equals('Пароль далжен состоять из английских символов и цифр и быть длинее 8 знаков');
    }

    /* проверка на размер пароля */
    public function testSmallPassword()
    {
        $form = $this->generateData(
            'test',
            'test',
            'test@gmail.com',
            '+38(121)-111-1111',
            'qwe',
            'password',
            '1');

        expect_not($form->validate());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))->equals('Значение «Пароль» должно содержать минимум 8 символов.');
    }

    /* проверка на уникальность почты */
    public function testUniqueEmail()
    {
        $form = $this->generateData(
            'test',
            'test',
            'unique@gmail.com',
            '+38(095)-111-1111',
            'password',
            'password',
            '1');

        expect_not($form->validate());
        expect_that($form->getErrors('email'));
        expect($form->getFirstError('email'))->equals('Пользователь с такой почтой уже зарегистрирован');
    }

    /* проверка на уникальность телефона */
    public function testUniquePhone()
    {
        $form = $this->generateData(
            'test',
            'test',
            'test@gmail.com',
            '+38(121)-111-1111',
            'password',
            'password',
            '1');

        expect_not($form->validate());
        expect_that($form->getErrors('phone'));
        expect($form->getFirstError('phone'))->equals('Пользователь с таким номером телефоном уже зарегистрирован');
    }

    /* генерация тестовых данных при регистрации */
    private function generateData($first_name,$last_name,$email,$phone,$password,$password_confirm,$confidentiality)
    {
        return new SignupForm([
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'password_confirm' => $password_confirm,
            'confidentiality' => $confidentiality,
            'passport' => new PassportSignupForm([
                'first_name' => $first_name,
                'last_name' => $last_name
            ])
        ]);
    }

}