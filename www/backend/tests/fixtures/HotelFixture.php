<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class HotelFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\referenceBooks\models\Hotel';
    public $dataFile = 'backend/tests/fixtures/data/hotel.php';
}