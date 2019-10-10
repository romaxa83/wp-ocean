<?php
namespace backend\tests\fixtures\rbac;

use yii\test\ActiveFixture;

class RoleAssignmentFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\user\entities\rbac\RoleAssignment';
    public $dataFile = 'backend/tests/fixtures/rbac/data/role-assignment.php';
}