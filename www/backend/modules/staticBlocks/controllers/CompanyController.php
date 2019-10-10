<?php

namespace backend\modules\staticBlocks\controllers;

use Yii;
use yii\filters\VerbFilter;
use backend\modules\staticBlocks\forms\CompanyForm;
use backend\modules\staticBlocks\forms\search\CompanySearch;
use yii\filters\AccessControl;

class CompanyController extends StaticBlocksController
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
     * @perm('Просмотр блока "О компании" (блоки на гл.)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'blocks' => $this->static_repository->getData('company'),
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Редактирование блока "О компании" (блоки на гл.)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $block = $this->static_repository->get($id);
        $form = new CompanyForm($block);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->static_service->edit($id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                $this->error($e);
            }
        }

        return $this->render('update_'.$block->alias, [
            'model' => $form,
        ]);
    }
}