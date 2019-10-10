<?php

namespace backend\tests\unit\modules\blog\forms;

use backend\tests\fixtures\rbac\RoleFixture;
use backend\modules\user\forms\rbac\RoleForm;

class RoleFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \backend\tests\UnitTester
     */
    protected $tester;

    /* подгрузка данных в тестовую бд,перед тестами */
    public function _before()
    {
        $this->tester->haveFixtures([
            'role' => [
                'class' => RoleFixture::className(),
            ]
        ]);
    }

    /* проверка на ввод пустых значений */
    public function testEmpty()
    {
        $data = [];

        $role = $this->generateRole($data);

        expect_not($role->validate());

        expect_that($role->getErrors('name'));
        expect($role->getFirstError('name'))
            ->equals('Необходимо заполнить «Название Роли».');

        expect_that($role->getErrors('description'));
        expect($role->getFirstError('description'))
            ->equals('Необходимо заполнить «Описание Роли».');

    }

    public function testShort()
    {
        $data = [
            'name' => 'god',
            'description' => 'бог'
        ];

        $role = $this->generateRole($data);

        expect_not($role->validate());

        expect_that($role->getErrors('name'));
        expect($role->getFirstError('name'))
            ->equals('Роль должна состоять из английских символов и быть длинее 4 знаков');
    }

    public function testExistRole()
    {
        $data = [
            'name' => 'admin',
            'description' => 'Администратор'
        ];

        $role = $this->generateRole($data);

        expect_not($role->validate());

        expect_that($role->getErrors('name'));
        expect($role->getFirstError('name'))
            ->equals('Такая роль уже существует');
    }

    public function testSuccess()
    {
        $data = [
            'name' => 'author',
            'description' => 'Автор'
        ];

        $role = $this->generateRole($data);

        expect_that($role->validate());
    }

    private function generateRole($data)
    {
        $role = new RoleForm();
        $role->name = $data['name']??null;
        $role->description = $data['description']??null;

        return $role;
    }
}