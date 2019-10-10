<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class MediaFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\filemanager\models\Mediafile';
    public $dataFile = 'backend/tests/fixtures/data/media.php';
    public $depends = [
        'backend\tests\fixtures\PostCategoryFixture',
        'backend\tests\fixtures\CountryFixture',
    ];
}