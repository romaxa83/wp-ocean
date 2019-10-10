<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class CountryFixture extends ActiveFixture
{
    public $modelClass = 'backend\modules\referenceBooks\models\Country';
    public $dataFile = 'backend/tests/fixtures/data/country.php';
}