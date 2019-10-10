<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class TagAssignmentFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\blog\entities\TagAssignment';
    public $dataFile = 'backend/tests/fixtures/data/tag-assignment.php';
    public $depends = [
//        'backend\test\fixtures\PostFixture',
//        'backend\test\fixtures\TagFixture'
    ];

}