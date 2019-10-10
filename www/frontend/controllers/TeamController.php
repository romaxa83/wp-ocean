<?php

namespace frontend\controllers;

use Yii;
use yii\db\ActiveQuery;
use yii\web\Controller;
use backend\modules\content\models\SlugManager;
use backend\modules\content\models\PageText;
use backend\modules\content\models\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class TeamController extends BaseController {

    public function actionIndex() {
        $id = Yii::$app->request->get('id');
        $page_info = Page::find()
                ->where(['slug_id' => $id])
                ->asArray()
                ->with([
                    'pageMetas',
                    'pageText' => function(ActiveQuery $query) {
                        $query->indexBy('name');
                    }
                ])
                ->one();
        $this->renderBreadcrumbs([
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ], [
                'href' => Url::to(Yii::$app->request->url, TRUE),
                'name' => 'О компании'
            ]
        ]);
        return $this->render('about-us', [
                    'page' => $page_info
        ]);
    }

}
