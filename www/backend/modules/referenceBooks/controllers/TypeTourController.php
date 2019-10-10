<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\referenceBooks\models\TypeTour;
use backend\modules\referenceBooks\models\TypeTourSearch;
use yii\filters\AccessControl;

class TypeTourController extends Controller
{
    /** @var $access Access*/
    private $access;

    public function __construct($id, Module $module,array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->access = new Access();
    }

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
     * @perm('Просмотр типов туров (справочник)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $searchModel = new TypeTourSearch();
        $page = Yii::$app->user->identity->getSettings('type-tour')['count-page'][0]??10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание типа тура (справочник)')
     */
    public function actionCreate()
    {
        $this->access->accessAction();
        $model = new TypeTour();

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {

            $model->save();
            Yii::$app->session->setFlash('success', 'Тип тура создан');
            return $this->redirect(['index']);
        }

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * @perm('Редактирование типа тура (справочник)')
     */
    public function actionUpdate($id)
    {
        $this->access->accessAction();
        $model = TypeTour::findOne($id);

        $post = Yii::$app->request->post();
        if($model->load($post) && $model->validate()){
            $model->status = $this->isStatus($post);
            $model->sync = $this->isSync($post);

            $model->update();
            Yii::$app->session->setFlash('success', 'Тип тура отредактирован');
            return $this->redirect(['index']);
        }
        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * @perm('Удаление типа тура (справочник)')
     */
    public function actionDelete($id)
    {
        $this->access->accessAction();
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Тип тура удален');

        return $this->redirect(['index']);
    }

    /**
     * @perm('Смена статуса типа тура (справочник)')
     */
    public function actionUpdateStatus() : void
    {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $city = TypeTour::findOne($data['id']);
            $city->$name = (bool) $data['value'];
            $city->update(FALSE);
        }
    }

    private function isStatus($post) : bool
    {
        return isset($post["TypeTour"]['status']) && $post["TypeTour"]['status'] == 1 ? true : false;
    }

    private function isSync($post) : bool
    {
        return isset($post["TypeTour"]['sync']) && $post["TypeTour"]['sync'] == 1 ? true : false;
    }

    protected function findModel($id)
    {
        if (($model = TypeTour::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}