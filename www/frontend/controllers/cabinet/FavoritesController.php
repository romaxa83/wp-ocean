<?php

namespace frontend\controllers\cabinet;

use frontend\controllers\BaseController;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;

class FavoritesController extends BaseController
{
    public $layout = 'cabinet';


    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}