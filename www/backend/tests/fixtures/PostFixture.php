<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class PostFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\blog\entities\Post';
    public $dataFile = 'backend/tests/fixtures/data/post.php';
    public $depends = [
        'backend\tests\fixtures\PostCategoryFixture',
        'backend\tests\fixtures\CountryFixture',
        'backend\tests\fixtures\MediaFixture',
        'backend\tests\fixtures\SeoFixture',
        'backend\tests\fixtures\TagFixture',
    ];
}