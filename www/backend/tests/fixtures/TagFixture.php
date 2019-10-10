<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class TagFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\blog\entities\Tag';
    public $dataFile = 'backend/tests/fixtures/data/tag.php';
    public $depends = [
        'backend\tests\fixtures\TagAssignmentFixture',
    ];
}