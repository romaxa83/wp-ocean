<?php

namespace backend\tests\unit\modules\forms;

use backend\tests\fixtures\user\UserFixture;
use backend\modules\user\forms\UserForm;
use common\models\User;

class UserFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /**
     * @var $user User
     */
    private $user;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ]
        ]);

        $this->user = $this->tester->grabFixture('user', 1);
    }
//
//    public function testEmptyValue()
//    {
//        $data = [
//            'email' => 'test@test.com',
//            'phone' => '+38(444)-444-4444',
//            'password' => 'romaxa'
//        ];
//        $form = $this->generateUser($data);
//        $form->setScenario(UserForm::CREATE_USER);
//        dd($form);
//    }
//
//    private function generateUser($array)
//    {
//        $user = User::create(
//            $array['email']??null,
//            $array['phone']??null,
//            $array['password']??null
//        );
//        $form = new UserForm($user,['scenario' => UserForm::CREATE_USER]);
//        dd($form);
//
//        return $form;
//    }




    public function testWrongEmail()
    {
        $this->user->email = 'erwerwerw';
        $form = new UserForm($this->user);
        $form->setScenario(UserForm::EDIT_USER);
        expect_not($form->validate());
    }

    public function testEmptyEmailEdit()
    {
        $this->user->email = null;
        $form = new UserForm($this->user);
        $form->setScenario(UserForm::EDIT_USER);
        expect($form->validate());
    }

    public function testEmptyEmailCreate()
    {
        $this->user->email = null;
        $form = new UserForm($this->user);
        $form->setScenario(UserForm::CREATE_USER);
        expect_not($form->validate());
    }

    public function testEmptyPhone()
    {
        $this->user->phone = null;
        $form = new UserForm($this->user);
        $form->setScenario(UserForm::EDIT_USER);
        expect_not($form->validate());
    }
}