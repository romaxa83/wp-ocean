<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class PostCategoryFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\blog\entities\Category';
    public $dataFile = 'backend/tests/fixtures/data/post-category.php';
}