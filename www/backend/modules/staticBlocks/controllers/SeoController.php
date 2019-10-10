<?php

namespace backend\modules\staticBlocks\controllers;

use Yii;
use yii\filters\VerbFilter;
use backend\modules\staticBlocks\forms\SeoForm;
use backend\modules\staticBlocks\forms\CounterForm;
use backend\modules\staticBlocks\forms\search\SeoSearch;
use yii\filters\AccessControl;

class SeoController extends StaticBlocksController
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
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ]
        ];
    }

    /**
     * @perm('Просмотр блока "Seo" (блоки на гл.)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new SeoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blocks' => $this->static_repository->getData('seo'),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создания блока "Seo" (блоки на гл.)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $form = new SeoForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->static_service->create($form);
                Yii::$app->session->setFlash('success', 'Секция для SEO-блока, создана');
                return $this->redirect(['index']);

            } catch (\DomainException $e) {
                $this->error($e);
            }
        }
        return $this->render('create', [
            'model' => $form,
            'last_position' => $this->static_repository->getLastPosition('seo')
        ]);
    }

    /**
     * @perm('Редактирование блока "Seo" (блоки на гл.)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $block = $this->static_repository->get($id);
        $form = new SeoForm($block);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->static_service->edit($id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                $this->error($e);
            }
        }
        return $this->render('update', [
            'model' => $form,
            'count_position' => $this->static_repository->getCount('seo')
        ]);
    }
}