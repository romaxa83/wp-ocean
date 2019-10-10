<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use cijic\phpMorphy\Morphy;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','front', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','add-settings','remove-settings'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];

    }

//    public function actionError()
//    {
//        $exception = Yii::$app->errorHandler->exception;
//        if($exception !== null){
//            //редирект пользователя на форму входа в админку
//            $statusCode = $exception->statusCode;
//            if(Yii::$app->user->isGuest && $statusCode === 404){
//                return $this->redirect(Url::to('site/login'));
//            }
//
//            return $this->render('/site/error');
//        }
//
//    }

    public function actionIndex() {
//        $morphy = new Morphy();
//        $str = mb_strtoupper('Кемер');
//        var_dump($morphy->getAllFormsWithAncodes($str));
//        var_dump($morphy->castFormByGramInfo($str, null, array('ЕД', 'РД'), true));
        return $this->render('index');
    }

    /**
     * Login action.
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())
            && $model->validate()
            && $this->isNotUser($model->email)
            && $model->login()
        )
        {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionFront()
    {
        return $this->redirect(\Yii::$app->urlManagerFrontend->createUrl('/error'));
    }

    public function actionAddSettings()
    {
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $user = User::findOne($post['user_id']);
            $user->addSetting($post['model'],$post['type'],$post['attr']);
        }
    }

    public function actionRemoveSettings()
    {
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $user = User::findOne($post['user_id']);
            $user->removeSetting($post['model'],$post['type'],$post['attr']);
        }
    }

    /**
     * @param $email
     * @return bool
     */
    private function isNotUser($email)
    {
        /** @var $user User*/
        $user = User::findByEmail($email);
        return $user !== null && $user->getRole() !== 'user';
    }

}
