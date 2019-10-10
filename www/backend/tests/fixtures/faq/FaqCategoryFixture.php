<?php
namespace backend\tests\fixtures\faq;

use yii\test\ActiveFixture;

class FaqCategoryFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\faq\models\Category';
    public $dataFile = 'backend/tests/fixtures/faq/data/category.php';
}