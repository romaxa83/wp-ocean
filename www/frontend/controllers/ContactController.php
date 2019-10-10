<?php

namespace frontend\controllers;

use backend\modules\content\models\Page;
use Yii;
use yii\db\ActiveQuery;
use yii\web\Controller;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

class ContactController extends BaseController {

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

        $setings = Settings::find()->where(['in', 'name', ['contact']])->asArray()->all();
        $setings = ArrayHelper::index($setings, 'name');
        $setings['contact']['body'] = Json::decode($setings['contact']['body']);
        $this->renderBreadcrumbs([
            [
                'href' => Url::to('/', TRUE),
                'name' => 'Главная'
            ], [
                'href' => Url::to(Yii::$app->request->url, TRUE),
                'name' => 'Контакты'
            ]
        ]);
        return $this->render('index', [
            'setings' => $setings,
            'page' => $page_info
        ]);
    }

}
