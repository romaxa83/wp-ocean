<?php

namespace backend\tests\unit\modules\faq;

use http\Exception;
use common\models\User;
use backend\tests\fixtures\user\UserFixture;
use backend\modules\user\entities\rbac\Role;
use backend\modules\user\forms\rbac\RoleForm;
use backend\modules\user\services\RbacService;

class RbacServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /** @var $user User */
    private $user;

    /**
     * @var RbacService
     */
    private $rbacService;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
            ],
        ]);

        $this->user = $this->tester->grabFixture('user', 1);

        $this->rbacService = new RbacService();
    }

    public function _after()
    {
        Role::deleteAll();
    }

    public function testCreateRole()
    {
        $role = new RoleForm();
        $role->name = 'author';
        $role->description = 'Автор';

        $roleSave = $this->rbacService->createRole($role);

        expect($roleSave instanceof \yii\rbac\Role)->true();
        expect($roleSave->name)->equals($role->name);
        expect($roleSave->description)->equals($role->description);
        expect($roleSave->type)->equals(Role::ROLE);
    }

    /**
     * @expectedException Exception
     */
    public function testAssignmentRoleException()
    {
        $this->rbacService->assignmentRole('moderator',$this->user->id);
    }

    public function testAssignmentRole()
    {
        $role = 'manager';
        $this->rbacService->assignmentRole($role,$this->user->id);

        expect($this->user->getRole())->equals($role);
    }

    public function testGetAllRole()
    {
        $dataRoles = [
            'admin' => 'Администратор',
            'manager' => 'Менеджер',
            'moderator' => 'Модератор',
            'user' => 'Пользователь',
        ];
        $roles = $this->rbacService->getAllRole();

        expect($roles)->equals($dataRoles);
    }

    public function testGetAllRoleExceptAdmin()
    {
        $dataRoles = [
            'manager' => 'Менеджер',
            'moderator' => 'Модератор',
            'user' => 'Пользователь',
        ];
        $roles = $this->rbacService->getAllRole(['admin']);

        expect($roles)->equals($dataRoles);
    }

    public function testGetAllPermission()
    {
        $dataPermission = [
            'blog/category/create' => 'Cоздание категории (блог)',
            'blog/category/delete' => 'Удаление категории (блог)',
            'user/user/create' => 'Cоздание пользователя (пользователи)',
            'user/user/delete' => 'Удаление пользователя (пользователи)',
        ];
        $permissions = $this->rbacService->getAllPermission();

        expect($permissions)->equals($dataPermission);
    }

    public function testGetAllPermissionByGroup()
    {
        $dataPermission = [
            'blog/category/create' => 'Cоздание категории (блог)',
            'blog/category/delete' => 'Удаление категории (блог)',
        ];
        $permissions = $this->rbacService->getAllPermission('блог');

        expect($permissions)->equals($dataPermission);
    }

    public function testGetGroupPermissions()
    {
        $dataGroups = [
            'все' => 'все',
            'блог' => 'блог',
            'пользователи' => 'пользователи',
            'без группы' => 'без группы'
        ];
        $groups = $this->rbacService->getGroupPermissions();

        expect($groups)->equals($dataGroups);
    }
}