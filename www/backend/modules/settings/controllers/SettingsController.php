<?php

namespace backend\modules\settings\controllers;


use Yii;
use yii\base\Module;
use yii\helpers\Json;
use yii\web\Controller;
use backend\models\Settings;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\user\useCase\Access;

class SettingsController extends Controller {

    /** $var $access Access */
    private $access;

    public function __construct($id, Module $module,
                                array $config = [])
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
     * @perm('Просмотр настроек (настройки)')
     */
    public function actionIndex()
    {
        $this->access->accessAction();
        $settings = Settings::find()->where(['in', 'name', ['contact', 'social']])->asArray()->all();
        $settings = ArrayHelper::index($settings, 'name');
        $settings['contact']['body'] = Json::decode($settings['contact']['body']);
        $settings['social']['body'] = Json::decode($settings['social']['body']);
        return $this->render('index', [
            'settings' => $settings
        ]);
    }

    /**
     * @perm('Сохранения настроек (настройки)')
     */
    public function actionSave()
    {
        $this->access->accessAction();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $settings = Settings::find()->where(['name' => $data['action']])->one();
            $settings->body = Json::encode($data['data']);
            $settings->save();
        }
    }

}
