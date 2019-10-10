<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class SeoFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\blog\entities\Meta';
    public $dataFile = 'backend/tests/fixtures/data/seo-meta.php';
}