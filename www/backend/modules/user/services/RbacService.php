<?php

namespace backend\modules\user\services;

use backend\modules\user\entities\rbac\PermissionForRole;
use backend\modules\user\entities\rbac\Role;
use backend\modules\user\forms\rbac\RoleForm;
use yii\base\Exception;
use yii\helpers\ArrayHelper;;

class RbacService
{
    private $groupAll = 'все';
    private $groupOther = 'без группы';

    /**
     * @var \yii\rbac\ManagerInterface
     */
    private $authManger;

    /**
     * RbacService constructor.
     */
    public function __construct()
    {
        $this->authManger = \Yii::$app->authManager;
    }

    /**
     * создает роль
     * @param RoleForm $form
     * @return \yii\rbac\Role
     */
    public function createRole(RoleForm $form)
    {
        $role = $this->authManger->createRole($form->name);
        $role->description = $form->description;
        $this->authManger->add($role);

        return $role;
    }

    /**
     * привязывает роль к пользователю
     * @param $role
     * @param $userId
     * @throws Exception
     */
    public function assignmentRole($role, $userId)
    {
        if (!$this->isRole($role)){
            throw new Exception('Такой роли нет или она указана неверно');
        }
        $getRole = $this->authManger->getRole($role);
        $this->authManger->assign($getRole, $userId);
    }

    /**
     * отвязывает пользователя от ролей
     * @param $userId
     */
    public function removeRoleForUser($userId)
    {
        $this->authManger->revokeAll($userId);
    }

    /**
     * отвязывает роль от пользователя
     * @param $role
     * @param $userId
     */
    public function detachedRole($role, $userId)
    {
        $_role = $this->authManger->getRole($role);
        $this->authManger->revoke($_role,$userId);
    }

    /**
     * привязывает к роли разрешения
     * @param $role
     * @param array $permissions
     */
    public function attachPermission($role, array $permissions,$group)
    {
        $_role = $this->authManger->getRole($role);

        $groupPermissions = self::getAllPermission($group);
        foreach (array_flip($groupPermissions) as $permission){
            if($perm = PermissionForRole::findOne(['child' => $permission,'parent' => $role])){
                $perm->delete();
            }
        }
        if(is_array($permissions) && !empty($permissions)){
            foreach ($permissions as $permission){
                $perm = $this->authManger->getPermission($permission);
                $this->authManger->addChild($_role,$perm);
            }
        }
    }

    /**
     * удаляет все привязанные разрешения к роли
     * @param $role
     */
    public function removePermissionsFromRole($role)
    {
        PermissionForRole::deleteAll(['parent' => $role]);
    }

    /**
     * проверяет существование роли
     * @param string $role
     * @return bool
     */
    public function isRole($role)
    {
        $all_role = ArrayHelper::index($this->getData(Role::ROLE),'name');
        return array_key_exists($role,$all_role);
    }

    /**
     * возвращает массив ролей,где
     * ключ - роль ,а значение - описание
     * @param array|null $except - массив ролей,которые надо исключить из выборки
     * @return array
     */
    public function getAllRole($except = null)
    {
        return array_map(function($item){
            return $item['description'];
        },ArrayHelper::index($this->getData(Role::ROLE,$except),'name'));
    }

    /**
     * метод получает строку с именами ролей
     * возвращает массив где ключ - имя роли ,а значение - описание роли
     * @param $strRolesName
     * @return array
     */
    public function getArrayRolesByStringNames($strRolesName)
    {
        $roles = [];
        foreach (explode(',',$strRolesName) as $roleName){
            $role = $this->authManger->getRole($roleName);
            $roles[$roleName] = $role->description;
        }
        return $roles;
    }

    /**
     * возвращает массив разрешений,где
     * ключ - разрешение ,а значение - описание
     * @param string|null $group
     * @return array
     */
    public function getAllPermission($groupName = false)
    {
        $permissions = ArrayHelper::index($this->getData(Role::PERMISSION),'name');
        if($groupName && $groupName !== $this->groupAll){
            if($groupName === $this->groupOther){
                $permissions = array_filter($permissions,function($item) use ($groupName){
                    return !(preg_match('/\(/',$item['description']));
                });
            } else {
                $permissions = array_filter($permissions,function($item) use ($groupName){
                    return preg_match('/\('. $groupName .'\)/',$item['description']);
                });
            }
        }
        return array_map(function($item){
            return $item['description'];
        },$permissions);
    }

    public function getPermissionByRole($role,$groupName = false)
    {
        $permissionRole = PermissionForRole::find()->where(['parent' => $role])->asArray()->all();

        $check = array_map(function($item){
            return $item['child'];
        },$permissionRole);
        return array_flip($check);
    }

    /**
     * возвращает массив с названием групп разрешений
     * @return array|string
     */
    public function getGroupPermissions()
    {
        $arr = [];
        if(!empty($this->getAllPermission())){
            foreach ($this->getAllPermission() as $perm){
                if($group = strstr($perm,'(')){
                    $arr[] = $group;
                }
            }
        }

        if(!empty($arr)){
            $result[$this->groupAll] = $this->groupAll;
            foreach (array_unique($arr) as $group){
                $groupName = substr(substr($group,1),0,-1);
                $result[$groupName] = $groupName;
            }
            $result[$this->groupOther] = $this->groupOther;
            return $result;
        }
        return $arr;
    }

    /**
     * удаляет роль к которой не привязанны пользователи
     * @param $role
     * @return bool
     */
    public function removeRole($role)
    {
       if($this->authManger->getUserIdsByRole($role)){
            return false;
       }

       $_role = $this->authManger->getRole($role);
       $this->authManger->remove($_role);
       return true;
    }

    private function getData($type,$except = null)
    {
        if($except && is_array($except)){
            return Role::find()
                ->select(['name','description'])
                ->where(['type' => $type])
                ->andWhere(['not in','name',$except])
                ->asArray()->all();
        }
        return Role::find()->select(['name','description'])->where(['type' => $type])->asArray()->all();
    }

}