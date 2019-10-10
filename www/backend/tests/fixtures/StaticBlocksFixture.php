<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class StaticBlocksFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\staticBlocks\entities\Block';
    public $dataFile = 'backend/tests/fixtures/data/static-block.php';
}