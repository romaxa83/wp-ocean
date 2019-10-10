<?php

namespace backend\modules\seo\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\seo\models\SeoMeta;
use yii\filters\AccessControl;
//use app\modules\menu\models\Pages;

/**
 * Default controller for the `seo` module
 */
class DefaultController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }
    /**
     * Достает запись с сео данными
     * @return object
     */
    public function actionIndex($id = null)
    {
        if($id != null){
            $model = $this->language($groups = SeoMeta::find()->where(['id' => $id])->orWhere(['parent_id' => $id])->all(), ['h1', 'title','keywords','description','seo_text']);
            if($model == null)$model = new SeoMeta();
        }else {
            $model = new SeoMeta();
        }
        return $model;

    }
}
