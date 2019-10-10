<?php

namespace backend\tests\unit\modules\user;

use DomainException;
use common\models\User;
use backend\models\Settings;
use common\models\SignupForm;
use backend\tests\fixtures\MediaFixture;
use backend\modules\user\forms\UserForm;
use backend\tests\fixtures\SettingsFixture;
use backend\modules\user\entities\Passport;
use backend\modules\user\forms\PasswordForm;
use backend\modules\user\forms\UserEditForm;
use backend\tests\fixtures\user\UserFixture;
use backend\tests\fixtures\rbac\RoleFixture;
use backend\modules\user\entities\rbac\Role;
use backend\modules\user\helpers\DateFormat;
use backend\modules\user\services\RbacService;
use backend\modules\user\services\UserService;
use backend\tests\fixtures\user\PassportFixture;
use backend\modules\dispatch\entities\Subscriber;
use backend\modules\user\events\UserSignUpConfirm;
use backend\modules\user\repository\AuthRepository;
use backend\modules\user\repository\UserRepository;
use backend\modules\user\events\UserSignUpRequested;
use backend\modules\user\repository\MediaRepository;
use backend\tests\fixtures\rbac\RoleAssignmentFixture;
use backend\modules\user\entities\rbac\RoleAssignment;
use backend\modules\user\repository\PassportRepository;
use backend\modules\user\repository\IntPassportRepository;
use backend\modules\user\repository\SmartMailingRepository;
use backend\modules\dispatch\repository\SubscriberRepository;
use backend\modules\user\repository\PassportAssignmentRepository;

class UserServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /**
     * @var $userService UserService
     */
    private $userService;

    public function _before()
    {
        $this->tester->haveFixtures([
            'role' => [
                'class' => RoleFixture::className()
            ],
            'roleAssignment' => [
                'class' => RoleAssignmentFixture::className()
            ],
            'user' => [
                'class' => UserFixture::className()
            ],
            'media' => [
                'class' => MediaFixture::className()
            ],
            'settings' => [
                'class' => SettingsFixture::className()
            ],
            'passport' => [
                'class' => PassportFixture::className()
            ]
        ]);

        $this->userService = new UserService(
            new UserRepository(),
            new PassportRepository(),
            new IntPassportRepository(),
            new AuthRepository(),
            new SubscriberRepository(),
            new SmartMailingRepository(),
            new MediaRepository(),
            new RbacService(),
            new PassportAssignmentRepository()
        );
    }

    public function _after()
    {
        User::deleteAll();
        Passport::deleteAll();
        Subscriber::deleteAll();
        RoleAssignment::deleteAll();
    }

    public function testCreateUserForRoleUser()
    {
        /* @var $role Role */
        $role = $this->tester->grabFixture('role', 'user');
        $data = [
            'UserForm' => [
                'role' => $role->name,
                'email' => 'email@email.com',
                'phone' => '+38(093)-234-5678',
                'password' => 'password',
            ],
            'PassportForm' => [
                'first_name' => 'Bruce',
                'last_name' => 'Lee',
            ]
        ];

        $form = new UserForm();
        $form->setScenario(UserForm::CREATE_USER);
        $this->assertTrue($form->load($data));
        $user = $this->userService->create($form);

        expect($user->save())->true();

        $userSave = (new UserRepository())->get($user->id);

        expect($userSave->email)->equals($data['UserForm']['email']);
        expect($userSave->phone)->equals($data['UserForm']['phone']);
        expect($userSave->password_hash)->notEquals($data['UserForm']['password']);
        expect($userSave->password_hash)->notNull();
        expect($userSave->getRole())->equals($data['UserForm']['role']);
        expect($userSave->auth_key)->notNull();
        expect($userSave->status)->equals(User::STATUS_ACTIVE);
        expect($userSave->confirm_token)->null();
        expect($userSave->dispatch)->equals(0);
        expect($userSave->created_at)->notNull();
        expect($userSave->updated_at)->notNull();

        expect($userSave->passport->first_name)->equals($data['PassportForm']['first_name']);
        expect($userSave->passport->last_name)->equals($data['PassportForm']['last_name']);
    }

    public function testCreateUserFromSignUp(): void
    {
        $data = [
            'SignupForm' => [
                'email' => 'email@email.com',
                'phone' => '+38(093)-234-5678',
                'password' => 'password',
                'password_confirm' => 'password',
                'confidentiality' => 'on'
            ],
            'PassportSignupForm' => [
                'first_name' => 'Bruce',
                'last_name' => 'Lee',
            ]
        ];

        $form = new SignupForm();
        $this->assertTrue($form->load($data));
        $this->assertTrue($form->validate());
        $user = $this->userService->createByRegistration($form);

        expect($user->save())->true();
        expect($user->releaseEvents()[0] instanceof UserSignUpConfirm)->true();

        $userSave = (new UserRepository())->get($user->id);

        expect($userSave->email)->equals($data['SignupForm']['email']);
        expect($userSave->phone)->equals($data['SignupForm']['phone']);
        expect($userSave->password_hash)->notEquals($data['SignupForm']['password']);
        expect($userSave->password_hash)->notNull();
        expect($userSave->getRole())->equals('user');
        expect($userSave->auth_key)->notNull();
        expect($userSave->status)->equals(User::STATUS_DRAFT);
        expect($userSave->confirm_token)->notNull();
        expect_that(is_string($userSave->confirm_token));
        expect($userSave->dispatch)->equals(0);
        expect($userSave->created_at)->notNull();
        expect($userSave->updated_at)->notNull();

        expect($userSave->passport->first_name)->equals($data['PassportSignupForm']['first_name']);
        expect($userSave->passport->last_name)->equals($data['PassportSignupForm']['last_name']);
    }

    public function testCreateUserFullDataForRoleUser()
    {
        /* @var $role Role */
        $role = $this->tester->grabFixture('role', 'user');
        $data = [
            'UserForm' => [
                'role' => $role->name,
                'email' => 'email@email.com',
                'phone' => '+38(093)-234-5678',
                'password' => 'password',
            ],
            'PassportForm' => [
                'first_name' => 'Bruce',
                'last_name' => 'Lee',
                'patronymic' => 'Dragon',
                'birthday' => '07/07/2016',
                'series' => 'SE',
                'number' => '23232323',
                'issued' => 'test',
                'issued_date' => '07/07/2016',
            ]
        ];

        $form = new UserForm();
        $form->setScenario(UserForm::CREATE_USER);
        $this->assertTrue($form->load($data));
        $user = $this->userService->create($form);

        expect($user->save())->true();

        $userSave = (new UserRepository())->get($user->id);

        expect($userSave->passport->first_name)->equals($data['PassportForm']['first_name']);
        expect($userSave->passport->last_name)->equals($data['PassportForm']['last_name']);
        expect($userSave->passport->patronymic)->equals($data['PassportForm']['patronymic']);
        expect($userSave->passport->series)->equals($data['PassportForm']['series']);
        expect($userSave->passport->number)->equals($data['PassportForm']['number']);
        expect($userSave->passport->issued)->equals($data['PassportForm']['issued']);
        expect($userSave->passport->birthday)->notEquals($data['PassportForm']['birthday']);
        expect($userSave->passport->birthday)->equals(DateFormat::forSave($data['PassportForm']['birthday']));
        expect($userSave->passport->issued_date)->notEquals($data['PassportForm']['issued_date']);
        expect($userSave->passport->issued_date)->equals(DateFormat::forSave($data['PassportForm']['issued_date']));
        expect($userSave->passport->verify)->equals(Passport::PASSPORT_VERIFY_DRAFT);
    }

    public function testCreateUserForAnotherRole()
    {
        /* @var $role Role */
        $role = $this->tester->grabFixture('role', 'manager');
        $data = [
            'UserForm' => [
                'role' => $role->name,
                'email' => 'email@email.com',
                'phone' => '+38(093)-234-5678',
                'password' => 'password',
            ],
            'PassportForm' => [
                'first_name' => 'Bruce',
                'last_name' => 'Lee',
            ]
        ];

        $form = new UserForm();
        $form->setScenario(UserForm::CREATE_USER);
        $this->assertTrue($form->load($data));
        $user = $this->userService->create($form);

        expect($user->save())->true();

        $userSave = (new UserRepository())->get($user->id);

        expect($userSave->email)->equals($data['UserForm']['email']);
        expect($userSave->phone)->equals($data['UserForm']['phone']);
        expect($userSave->password_hash)->notEquals($data['UserForm']['password']);
        expect($userSave->password_hash)->notNull();
        expect($userSave->getRole())->equals($data['UserForm']['role']);
        expect($userSave->auth_key)->notNull();
        expect($userSave->status)->equals(User::STATUS_ACTIVE);
        expect($userSave->dispatch)->equals(0);
        expect($userSave->created_at)->notNull();
        expect($userSave->updated_at)->notNull();
        expect($userSave->passport->first_name)->equals($data['PassportForm']['first_name']);
        expect($userSave->passport->last_name)->equals($data['PassportForm']['last_name']);
    }

    public function testUpdateUser()
    {
        /* @var $userOld User */
        $userOld = clone $this->tester->grabFixture('user', 3);
        /* @var $role Role */
        $role = $this->tester->grabFixture('role', 'user');
        $data = [
            'UserForm' => [
                'role' => $role->name,
                'email' => 'email@email.com',
                'phone' => '+38(093)-234-5678',
                'password' => 'password',
            ],
            'PassportForm' => [
                'first_name' => 'Bruce',
                'last_name' => 'Lee',
                'patronymic' => 'Dragon',
                'birthday' => '07/07/2016',
                'series' => 'SE',
                'number' => '23232323',
                'issued' => 'test',
                'issued_date' => '07/07/2016',
            ]
        ];

        $form = new UserForm($userOld);
        $form->setScenario(UserForm::EDIT_USER);
        $this->assertTrue($form->load($data));

        $user = $this->userService->edit($form,$userOld->id);

        expect($user->phone)->notEquals($userOld->phone);
        expect($user->phone)->equals($data['UserForm']['phone']);

        expect($user->email)->notEquals($userOld->email);
        expect($user->email)->equals($data['UserForm']['email']);

        expect($user->passport->first_name)->notEquals($userOld->passport->first_name);
        expect($user->passport->first_name)->equals($data['PassportForm']['first_name']);

        expect($user->passport->last_name)->notEquals($userOld->passport->last_name);
        expect($user->passport->last_name)->equals($data['PassportForm']['last_name']);

        expect($user->passport->patronymic)->notEquals($userOld->passport->patronymic);
        expect($user->passport->patronymic)->equals($data['PassportForm']['patronymic']);

        expect($user->passport->series)->notEquals($userOld->passport->series);
        expect($user->passport->series)->equals($data['PassportForm']['series']);

        expect($user->passport->number)->notEquals($userOld->passport->number);
        expect($user->passport->number)->equals($data['PassportForm']['number']);

        expect($user->passport->issued)->notEquals($userOld->passport->issued);
        expect($user->passport->issued)->equals($data['PassportForm']['issued']);
    }

    public function testChangePassword()
    {
        /* @var $userOld User */
        $user = $this->tester->grabFixture('user', 3);

        $data = [
            'PasswordForm' => [
                'password' => 'romaxa',
                'password_new' => 'new_password',
                'password_confirm' => 'new_password',

            ]
        ];

        $form = new PasswordForm($user->id);
        $this->assertTrue($form->load($data));

        $this->userService->changePassword($form);
        $userNewPassword = (new UserRepository())->get($user->id);

        expect($user->id)->equals($userNewPassword->id);
        expect($user->password_hash)->notEquals($userNewPassword->password_hash);
    }

    public function testChangePhoneAndEmail()
    {
        /* @var $userOld User */
        $user = $this->tester->grabFixture('user', 3);

        $data = [
            'UserEditForm' => [
                'phone' => '+38(009)-999-9999',
                'email' => 'new.email@email.com',

            ]
        ];

        $form = new UserEditForm($user);
        $this->assertTrue($form->load($data));

        $this->userService->editUser($form,$user->id);
        $userEdit = (new UserRepository())->get($user->id);

        expect($user->id)->equals($userEdit->id);

        expect($userEdit->email)->notEquals($user->email);
        expect($userEdit->email)->equals($data['UserEditForm']['email']);

        expect($userEdit->phone)->notEquals($user->phone);
        expect($userEdit->phone)->equals($data['UserEditForm']['phone']);
    }

    public function testSetAvatar()
    {
        /* @var $user User */
        $user = $this->tester->grabFixture('user', 1);
        $media = $this->tester->grabFixture('media', 2);

        expect($user->media_id)->null();

        $this->userService->setAvatar($user->id,$media->id);

        $userAvatar = (new UserRepository())->get($user->id);
        expect($userAvatar->id)->equals($user->id);
        expect($userAvatar->media_id)->equals($media->id);
        expect($userAvatar->media->filename)->equals($media->filename);
    }

    public function testVerifyToggle()
    {
        $name = 'verify_passport';
        $settings = $this->tester->grabFixture('settings', 'verifyPassport');

        expect($settings->name)->equals($name);
        expect($settings->body)->equals(Passport::PASSPORT_VERIFY_DRAFT);

        $this->userService->verifyToggle(Passport::PASSPORT_VERIFY_ACTIVE,$name);

        /* @var $settingsUpdate Settings */
        $settingsUpdate = Settings::findOne(['name' => $name]);

        expect($settingsUpdate->name)->equals($name);
        expect($settingsUpdate->body)->equals(Passport::PASSPORT_VERIFY_ACTIVE);
    }

    public function testDispatchToggle()
    {
        /* @var $user User */
        $user = $this->tester->grabFixture('user', 3);

        expect($user->dispatch)->equals(0);
        expect((new SubscriberRepository())->getByUserId($user->id))->false();

        $this->userService->dispatchToggle($user->id,1);
        /* @var $subscriber Subscriber */
        $subscriber = (new SubscriberRepository())->getByUserId($user->id);
        $userEdit = (new UserRepository())->get($user->id);

        expect($userEdit->id)->equals($user->id);
        expect($userEdit->dispatch)->equals(1);
        expect($subscriber->user_id)->equals($user->id);
        expect($subscriber->email)->equals($user->email);
        expect($subscriber->status)->equals(Subscriber::STATUS_ON);
        expect($subscriber->user->email)->equals($user->email);
    }

    /**
     * @expectedException DomainException
     */
    public function testRemove()
    {
        /* @var $user User */
        $user = $this->tester->grabFixture('user', 3);
        $this->userService->dispatchToggle($user->id,1);
        /* @var $subscriber Subscriber */
        $subscriber = (new SubscriberRepository())->getByUserId($user->id);
        $passport = (new PassportRepository())->get($user->passport_id);
        expect($subscriber->user_id)->equals($user->id);
        expect($passport->first_name)->equals($user->passport->first_name);

        $this->userService->remove($user->id);

        expect((new UserRepository())->get($user->id))->false();
        expect((new PassportRepository())->get($user->passport_id))->false();
        expect((new SubscriberRepository())->getByUserId($user->id))->false();
    }

    public function testConfirmSignUp()
    {
        $user = $this->tester->grabFixture('user', 'confirm');

        expect($user->status)->equals(User::STATUS_DRAFT);
        expect($user->confirm_token)->notNull();

        $userConfirm = $this->userService->confirmSignUp($user->confirm_token);

//        expect($user->releaseEvents()[0] instanceof UserSignUpRequested)->true();

        expect($userConfirm->id)->equals($user->id);
        expect($userConfirm->status)->equals(User::STATUS_ACTIVE);
        expect($userConfirm->confirm_token)->null();
    }
}