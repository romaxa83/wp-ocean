<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\modules\referenceBooks\models\TypeFood;
use backend\modules\referenceBooks\models\TypeFoodSearch;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\models\Hash;
use common\service\CacheService;
use yii\filters\AccessControl;

class TypeFoodController extends Controller {

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
     * @perm('Просмотр типов питания (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new TypeFoodSearch();
        $page = Yii::$app->user->identity->getSettings('type_food')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание типа питания (справочник)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        if ($data = Yii::$app->request->post('TypeFood')) {
            $this->save($data);
        }
        $type_food = new TypeFood();
        if ($type_food->status === NULL) {
            $type_food->status = TRUE;
        }
        return $this->render('_form', [
                    'type_food' => $type_food
        ]);
    }

    /**
     * @perm('Редактирование типа питания (справочник)')
     */
    public function actionUpdate() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        $type_food = TypeFood::findOne($id);
        if ($data = Yii::$app->request->post('TypeFood')) {
            $this->save($data, $id);
        }
        return $this->render('_form', [
                    'type_food' => $type_food
        ]);
    }

    /**
     * @perm('Удаление типа питания (справочник)')
     */
    public function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        TypeFood::deleteAll(['id' => $id]);
        $this->redirect(['/referenceBooks/type-food']);
    }

    /**
     * @perm('Смена статуса типа питания (справочник)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $transport = TypeFood::findOne($data['id']);
            $transport->$name = (bool) $data['value'];
            $transport->update(FALSE);
            if ($name == 'sync' && $transport->$name == TRUE) {
                $service = new CacheService($data['id']);
                $service->model = new TypeFood();
                $service->key = 'code';
                $service->render();
            }
        }
    }

    public function actionUpdatePosition() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post('item');
            foreach ($data as $k => $v) {
                TypeFood::updateAll(['position' => $k], ['=', 'id', $v]);
            }
        }
    }

    private function save($data, $id = NULL) {
        $type_food = ($id === NULL) ? new TypeFood() : TypeFood::findOne($id);
        $type_food->name = $data['name'];
        $type_food->code = $data['code'];
        $type_food->description = $data['description'];
        $type_food->status = (isset($data['status'])) ? $data['status'] : FALSE;
        $type_food->sync = (isset($data['sync'])) ? $data['sync'] : FALSE;
        $type_food->save();
        $this->redirect(['/referenceBooks/type-food']);
    }

}
