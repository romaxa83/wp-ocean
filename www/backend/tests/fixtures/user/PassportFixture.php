<?php
namespace backend\tests\fixtures\user;

use yii\test\ActiveFixture;

class PassportFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\user\entities\Passport';
    public $dataFile = 'backend/tests/fixtures/user/data/passport.php';
}