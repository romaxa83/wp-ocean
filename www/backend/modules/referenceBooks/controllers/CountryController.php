<?php

namespace backend\modules\referenceBooks\controllers;

use backend\modules\user\useCase\Access;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use backend\modules\referenceBooks\models\Country;
use backend\modules\referenceBooks\models\CountrySearch;
use backend\models\Settings;
use backend\modules\referenceBooks\models\City;
use yii\filters\AccessControl;

class CountryController extends Controller {

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
     * @perm('Просмотр стран (справочник)')
     */
    public function actionIndex() {
        $this->access->accessAction();
        $searchModel = new CountrySearch();
        $page = Yii::$app->user->identity->getSettings('country')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page' => $page,
            'access' => $this->access
        ]);
    }

    /**
     * @perm('Создание страны (справочник)')
     */
    public function actionCreate() {
        $this->access->accessAction();
        if ($data = Yii::$app->request->post('Country')) {
            $this->save($data);
        }
        $country = new Country();
        return $this->render('_form', [
                    'country' => $country
        ]);
    }

    /**
     * @perm('Редактирование страны (справочник)')
     */
    public function actionUpdate() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        $country = Country::find()->where(['id' => $id])->with('city')->one();
        if ($data = Yii::$app->request->post('Country')) {
            $this->save($data, $id);
        }
        return $this->render('_form', [
                    'country' => $country
        ]);
    }

    /**
     * @perm('Удаление страны (справочник)')
     */
    public function actionDelete() {
        $this->access->accessAction();
        $id = Yii::$app->request->get('id');
        Country::deleteAll(['id' => $id]);
        $this->redirect(['/referenceBooks/country']);
    }

    /**
     * @perm('Изменение страны страны (справочник)')
     */
    public function actionUpdateStatus() {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $name = $data['name'];
            $country = Country::findOne($data['id']);
            $country->$name = (bool) $data['value'];
            $country->update(FALSE);
        }
    }

    public function actionUpdatePage() {
        if (Yii::$app->request->isAjax) {
            $page = (int) Yii::$app->request->post('page');
            $min = 0;
            $max = 100;
            $page = ($page < $min) ? $min : $page;
            $page = ($page > $max) ? $max : $page;
            $settings = Settings::find()->where(['name' => 'CountryPage'])->one();
            if ($settings === NULL)
                $settings = new Settings();
            $settings->name = 'CountryPage';
            $settings->body = $page;
            $settings->save();
            $this->redirect(['/referenceBooks/country']);
        }
    }

    private function save($data, $id = NULL) {
        $country = ($id === NULL) ? new Country() : Country::findOne($id);
        if ($id === NULL) {
            $cid = Country::find()->select(['id'])->orderBy(['id' => SORT_DESC])->limit(1)->asArray()->one();
            $country->cid = (int) '9' . $cid['id'];
        }
        $country->media_id = $data['media_id'];
        $country->code = $data['code'];
        $country->name = $data['name'];
        $country->alias = $data['alias'];
        $country->country_description = $data['country_description'];
        $country->doc_description = $data['doc_description'];
        $country->visa_description = $data['visa_description'];
        $country->lat = $data['lat'];
        $country->lng = $data['lng'];
        $country->zoom = $data['zoom'];
        $country->alpha_3_code = $data['alpha_3_code'];
        $country->region_id = $data['region_id'];
        $country->visa = (isset($data['visa'])) ? $data['visa'] : FALSE;
        $country->status = (isset($data['status'])) ? $data['status'] : FALSE;
        $country->sync = (isset($data['sync'])) ? $data['sync'] : FALSE;
        $country->save();
        $this->redirect(['/referenceBooks/country']);
    }

}
