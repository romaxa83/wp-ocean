<?php
namespace backend\tests\fixtures\rbac;

use yii\test\ActiveFixture;

class PermissionFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\user\entities\rbac\Role';
    public $dataFile = 'backend/tests/fixtures/rbac/data/permission.php';
}