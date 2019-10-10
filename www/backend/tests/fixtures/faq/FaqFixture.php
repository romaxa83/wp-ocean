<?php
namespace backend\tests\fixtures\faq;

use yii\test\ActiveFixture;

class FaqFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\faq\models\Faq';
    public $dataFile = 'backend/tests/fixtures/faq/data/faq.php';
    public $depends = [
        'backend\tests\fixtures\faq\FaqCategoryFixture'
    ];
}