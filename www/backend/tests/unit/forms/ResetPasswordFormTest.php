<?php

namespace backend\tests\unit\forms;

use frontend\models\ResetPasswordForm;
use backend\tests\fixtures\user\UserFixture;

class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    private $user;

    /* подгрузка пользователей в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ]
        ]);

        $this->user = $this->tester->grabFixture('user', 1);
    }

    public function testWrongToken()
    {
        $this->tester->expectException('yii\base\InvalidParamException', function() {
            new ResetPasswordForm(($this->tester->grabFixture('user', 'wrong'))->password_reset_token);
        });

        $this->tester->expectException('yii\base\InvalidParamException', function() {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    public function testCorrectToken()
    {
        $form = new ResetPasswordForm($this->user->password_reset_token);
        expect_that($form->resetPassword());
    }

    /* проверка на ввод пустых значений */
    public function testPasswordEmpty()
    {
        $form = $this->generateData(null,null,$this->user->password_reset_token);

        expect_not($form->validate());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))
            ->equals('Необходимо заполнить «Пароль».');

        expect_that($form->getErrors('password_confirm'));
        expect($form->getFirstError('password_confirm'))
            ->equals('Необходимо заполнить «Потверждение пароля».');
    }

    public function testPasswordWrong()
    {
        $form = $this->generateData('ываываыв',null,$this->user->password_reset_token);

        expect_not($form->validate());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))
            ->equals('Пароль далжен состоять из английских символов и цифр и быть длинее 8 знаков');
    }

    public function testPasswordConfirmWrong()
    {
        $form = $this->generateData('password','wrong_password',$this->user->password_reset_token);

        expect_not($form->validate());
        expect_that($form->getErrors('password_confirm'));
        expect($form->getFirstError('password_confirm'))
            ->equals('Пароли не совпадают');
    }

    public function testPasswordSmall()
    {
        $form = $this->generateData('wer',null,$this->user->password_reset_token);

        expect_not($form->validate());
        expect_that($form->getErrors('password'));
        expect($form->getFirstError('password'))
            ->equals('Значение «Пароль» должно содержать минимум 8 символов.');
    }

    public function testPasswordSuccess()
    {
        $form = $this->generateData('password','password',$this->user->password_reset_token);

        expect_that($form->validate());
    }

    /* генерация тестовых для зброса пароля */
    private function generateData($password,$passwordConfirm,$token)
    {
        return new ResetPasswordForm($token,[
            'password' => $password,
            'password_confirm' => $passwordConfirm
        ]);
    }

}