<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class PostReviewHotelFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\blog\entities\HotelReview';
    public $dataFile = 'backend/tests/fixtures/data/post-hotel-review.php';
    public $depends = [
        'backend\tests\fixtures\HotelFixture',
        'backend\tests\fixtures\MediaFixture',
        'backend\tests\fixtures\SeoFixture',
    ];
}