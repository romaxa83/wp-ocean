<?php

namespace backend\modules\vacancyNotification\controllers;

use backend\modules\vacancyNotification\models\VacancyNotificationSearch;
use Yii;
use backend\modules\vacancyNotification\models\VacancyNotification;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * NotificationController implements the CRUD actions for VacancyNotification model.
 */
class NotificationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','change-status'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all VacancyNotification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VacancyNotificationSearch();
        $page = Yii::$app->user->identity->getSettings('request')['count-page'][0] ?? 10;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $page);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChangeStatus()
    {
        $params = Yii::$app->request->queryParams;
        $notification = VacancyNotification::find()
            ->where(['id' => $params['id']])
            ->one();

        $notification->scenario = VacancyNotification::SCENARIO_WITHOUT_CAPTCHA;
        $notification->status = $params['status'];

        if($notification->save()) {
            Yii::$app->session->setFlash('success', "<p>Статус изменен</p>");
        }
        else {
            $errors = '';
            foreach ($notification->getErrors() as $fieldWithErrors) {
                foreach ($fieldWithErrors as $error) {
                    $errors .= '<p>' . $error . '</p>';
                }
            }
            Yii::$app->session->setFlash('error', $errors);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}