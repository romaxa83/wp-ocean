<?php
namespace backend\tests\fixtures\user;

use yii\test\ActiveFixture;

class ReviewFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\user\entities\Reviews';
    public $dataFile = 'backend/tests/fixtures/user/data/review.php';
    public $depends = [
        'backend\tests\fixtures\user\PassportFixture',
        'backend\tests\fixtures\user\UserFixture',
        'backend\tests\fixtures\HotelFixture'
    ];
}