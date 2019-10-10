<?php

namespace backend\tests\unit\modules\user\entities;

use common\models\User;
use backend\tests\fixtures\user\UserFixture;
use backend\tests\fixtures\rbac\RoleAssignmentFixture;
use yii\helpers\Json;

class UserTest extends \Codeception\Test\Unit
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
            ],
            'role-assignment' => [
                'class' => RoleAssignmentFixture::className(),
            ]
        ]);

        $this->user = $this->tester->grabFixture('user', 3);
    }

    public function _after()
    {
        User::deleteAll();
    }

    public function testCreate()
    {
        $user = User::create(
            $email = 'test@test.com',
            $phone = '+38(095)-345-4444',
            $password = 'password'
        );

        expect($user->email)->equals('test@test.com');
        expect($user->phone)->equals('+38(095)-345-4444');
        expect($user->phone)->notEquals('+38(095)3454444');
        expect($user->phone)->notEquals('380953454444');
        expect_that($user->validatePassword('password'));
        expect_not($user->validatePassword('admin'));
        expect($user->status)->equals(User::STATUS_ACTIVE);
        expect($user->dispatch)->equals(0);
        expect($user->username)->null();
        expect($user->settings)->null();
        expect($user->passport_int_id)->null();
        expect($user->passport_id)->null();
        expect($user->confirm_token)->null();
        expect($user->media_id)->null();
        expect($user->save())->true();
    }

    public function testCreateBySignUp()
    {
        $user = User::create(
            $email = 'test@test.com',
            $phone = '+38(095)-345-4444',
            $password = 'password',
            true
        );

        expect($user->email)->equals('test@test.com');
        expect($user->phone)->equals('+38(095)-345-4444');
        expect($user->phone)->notEquals('+38(095)3454444');
        expect($user->phone)->notEquals('380953454444');
        expect_that($user->validatePassword('password'));
        expect_not($user->validatePassword('admin'));
        expect($user->status)->equals(User::STATUS_DRAFT);
        expect($user->dispatch)->equals(0);
        expect($user->username)->null();
        expect($user->settings)->null();
        expect($user->passport_int_id)->null();
        expect($user->passport_id)->null();
        expect($user->media_id)->null();
        expect($user->confirm_token)->notNull();
        expect(is_string($user->confirm_token))->true();
        expect($user->save())->true();
    }

    public function testCreateByNetwork()
    {
        $user = User::createByNetwork(
            $email = 'test@test.com',
            $password = 'password'
        );

        expect($user->email)->equals($email);
        expect_that($user->validatePassword($password));
        expect($user->getAuthKey())->notNull();
        expect($user->dispatch)->equals(0);
        expect($user->status)->equals(User::STATUS_ACTIVE);
        expect($user->save())->true();
    }

    public function testEdit()
    {
        $email = 'update@test.com';
        $phone = '+38(999)-999-9999';

        expect($this->user->email)->notEquals($email);
        expect($this->user->phone)->notEquals($phone);

        $this->user->edit($email, $phone);

        expect($this->user->email)->equals($email);
        expect($this->user->phone)->equals($phone);
        expect($this->user->save())->true();
    }

    public function testEditWithPassword()
    {
        $email = 'update@test.com';
        $phone = '+38(999)-999-9999';
        $password = 'edit_password';

        expect($this->user->email)->notEquals($email);
        expect($this->user->phone)->notEquals($phone);
        expect($this->user->password_hash)->notEquals($this->user->setPassword($password));

        $this->user->edit($email, $phone, $password);

        expect($this->user->email)->equals($email);
        expect($this->user->phone)->equals($phone);
        expect_that($this->user->validatePassword($password));
        expect($this->user->save())->true();
    }

    public function testChangePassword()
    {
        $password = 'edit_password';
        $this->user->changePassword($password);

        expect_that($this->user->validatePassword($password));
        expect($this->user->save())->true();
    }

    public function testDispatchToggle()
    {
        expect($this->user->dispatch)->equals(0);
        $this->user->dispatchToggle(1);
        expect($this->user->dispatch)->equals(1);
        expect($this->user->save())->true();
    }

    public function testConfirm()
    {
        $user = $this->tester->grabFixture('user', 'confirm');
        expect($user->status)->equals(User::STATUS_DRAFT);
        expect($user->confirm_token)->notNull();

        $user->confirm();

        expect($user->status)->notEquals(User::STATUS_DRAFT);
        expect($user->status)->equals(User::STATUS_ACTIVE);
        expect($user->confirm_token)->null();
    }

    //test Settings
    public function testNewSettings()
    {
        $entity = 'post';
        $type = 'hide-col';
        $value = 'alias';

        $settings = [
            $entity => [
                $type => [
                    $value
                ]
            ]
        ];
        expect($this->user->settings)->null();

        $this->user->addSetting($entity,$type,$value);

        expect($this->user->settings)->notNull();
        expect($this->user->settings)->equals(JSON::encode($settings));
        expect($this->user->save())->true();
    }

    public function testAddSomeSettings()
    {
        $entity = 'post';
        $type = 'hide-col';
        $value = 'alias';

        $entity_1 = 'post';
        $type_1 = 'hide-col';
        $value_1 = 'title';

        $entity_2 = 'user';
        $type_2 = 'hide-col';
        $value_2 = 'email';

        $entity_3 = 'faq';
        $type_3 = 'count-page';
        $value_3 = 10;

        $settings = [
            $entity => [
                $type => [$value,$value_1]
            ],
            $entity_2 => [
                $type_2 => [$value_2]
            ],
            $entity_3 => [
                $type_3 => [$value_3]
            ]
        ];

        expect($this->user->settings)->null();

        $this->user->addSetting($entity,$type,$value);

        expect($this->user->settings)->notNull();
        expect($this->user->save())->true();

        $this->user->addSetting($entity_1,$type_1,$value_1);

        expect($this->user->save())->true();

        $this->user->addSetting($entity_2,$type_2,$value_2);

        expect($this->user->save())->true();

        $this->user->addSetting($entity_3,$type_3,$value_3);

        expect($this->user->save())->true();
        expect($this->user->settings)->equals(JSON::encode($settings));
    }

    public function testRemoveSettings()
    {
        $entity = 'post';
        $type = 'hide-col';
        $value = 'alias';

        $entity_1 = 'post';
        $type_1 = 'hide-col';
        $value_1 = 'title';

        $entity_2 = 'user';
        $type_2 = 'hide-col';
        $value_2 = 'email';

        $entity_3 = 'faq';
        $type_3 = 'count-page';
        $value_3 = 10;

        $settings = [
            $entity => [
                $type => [$value,$value_1]
            ],
            $entity_2 => [
                $type_2 => [$value_2]
            ],
            $entity_3 => [
                $type_3 => [$value_3]
            ]
        ];

        $delSettings_2 = [
            $entity => [
                $type => [$value,$value_1]
            ],
            $entity_2 => [
                $type_2 => []
            ],
            $entity_3 => [
                $type_3 => [$value_3]
            ]
        ];

        $delSettings_1 = [
            $entity => [
                $type => [$value]
            ],
            $entity_2 => [
                $type_2 => []
            ],
            $entity_3 => [
                $type_3 => [$value_3]
            ]
        ];

        $getSettings = [
            $type => [$value]
        ];

        $this->user->addSetting($entity,$type,$value);
        $this->user->addSetting($entity_1,$type_1,$value_1);
        $this->user->addSetting($entity_2,$type_2,$value_2);
        $this->user->addSetting($entity_3,$type_3,$value_3);

        expect($this->user->settings)->equals(JSON::encode($settings));

        $this->user->removeSetting($entity_2,$type_2,$value_2);

        expect($this->user->settings)->notEquals(JSON::encode($settings));
        expect($this->user->settings)->equals(JSON::encode($delSettings_2));

        $this->user->removeSetting($entity_1,$type_1,$value_1);

        expect($this->user->settings)->notEquals(JSON::encode($settings));
        expect($this->user->settings)->equals(JSON::encode($delSettings_1));
        expect($this->user->getSettings($entity))->equals($getSettings);
    }

    public function testGetRoleAndDescription()
    {
        expect($this->user->getRole())->equals('user');
        expect($this->user->getRoleDescription())->equals('Пользователь');
    }

    public function testGetRolesAndDescription()
    {
        $user = $this->tester->grabFixture('user', 1);
        expect($user->getRoles())->equals('moderator,user');
        expect($user->getRolesDescription())->equals('Модератор,Пользователь');
    }

    public function testGetFullName()
    {
        expect($this->user->getFullName())->equals($this->user->passport->first_name.' '.$this->user->passport->last_name);
    }
}