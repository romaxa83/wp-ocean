<?php
namespace backend\tests\fixtures;

use yii\test\ActiveFixture;

class SettingsFixture extends ActiveFixture
{
    public $modelClass = 'backend\models\Settings';
    public $dataFile = 'backend/tests/fixtures/data/settings.php';
}