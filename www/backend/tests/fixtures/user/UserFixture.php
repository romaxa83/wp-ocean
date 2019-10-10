<?php
namespace backend\tests\fixtures\user;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'common\models\User';
    public $dataFile = 'backend/tests/fixtures/user/data/user.php';
    public $depends = [
        'backend\tests\fixtures\user\PassportFixture',
        'backend\tests\fixtures\MediaFixture',
        'backend\tests\fixtures\rbac\RoleFixture',
        'backend\tests\fixtures\rbac\RoleAssignmentFixture',
        'backend\tests\fixtures\rbac\PermissionFixture',
    ];
}