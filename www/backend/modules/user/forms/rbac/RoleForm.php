<?php

namespace backend\modules\user\forms\rbac;

use yii\base\Model;
use backend\modules\user\entities\rbac\Role;

class RoleForm extends Model
{
    public $name;
    public $description;

    public function __construct(Role $role = null, $config = [])
    {
        if($role){
            $this->name = $role->name;
            $this->description = $role->description;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['name','description'],'required'],
            [['name','description'],'string'],
            ['name','validateRoleName'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z_-]{4,18}$/', 'message' => 'Роль должна состоять из английских символов и быть длинее 4 знаков'],
        ];
    }

    public function validateRoleName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $role = Role::findByname($this->name)?true:false;
            if ($role){
                $this->addError($attribute, 'Такая роль уже существует');
            }
        }
    }

    public function attributeLabels() : array
    {
        return [
            'name' => 'Название Роли',
            'description' => 'Описание Роли'
        ];
    }
}