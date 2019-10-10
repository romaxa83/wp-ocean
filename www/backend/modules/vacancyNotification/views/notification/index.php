<?php

use backend\modules\referenceBooks\models\CustomActionColumn;
use backend\modules\vacancyNotification\models\VacancyNotification;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel backend\modules\vacancyNotification\models\VacancyNotificationSearch */

$this->title = 'Уведомления по вакансиям';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancy-notification-index">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'filterModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'id',
                        'filter' => false,
                        'headerOptions' => ['width' => '5%'],
                    ],
                    'name',
                    [
                        'attribute' => 'phone',
                        'headerOptions' => ['width' => '10%'],
                    ],
                    'vacancy',
                    [
                        'attribute' => 'comment',
                        'headerOptions' => ['width' => '40%'],
                        'filter' => false,
                    ],
                    [
                        'attribute' => 'cv_path',
                        'filter' => false,
                        'headerOptions' => ['width' => '5%'],
                        'content' => function($data) {
                            $link = '<a href="' . $data->cv_path . '">Скачать</a>';
                            return $link;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'headerOptions' => ['width' => '10%'],
                        'filter' => array(
                            VacancyNotification::NEW => 'Новая',
                            VacancyNotification::ARCHIVE => 'Обработанная',
                            VacancyNotification::CANCELED => 'Удаленная'),
                        'content' => function($data) {
                            switch($data->status) {
                                case VacancyNotification::NEW :
                                    $status = 'Новая'; break;
                                case VacancyNotification::CANCELED :
                                    $status = 'Удаленная'; break;
                                case VacancyNotification::ARCHIVE :
                                    $status = 'Обработанная'; break;
                            }
                            return $status;
                        }
                    ],
                    //'created_at',

                    //['class' => 'yii\grid\ActionColumn'],
                    [
                        'class' => CustomActionColumn::className(),
                        'header'=>'Действия',
                        'filter' => '<a href="' . Url::to(['/vacancy-notification']) . '">Сбросить</a>',
                        'buttons' => [
                            'archive' => function($url, $model) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-ok"></span>',
                                    ['/vacancyNotification/notification/change-status',
                                        'id' => $model->id,
                                        'status' => VacancyNotification::ARCHIVE
                                    ],
                                    [
                                        'title' => 'В архив'
                                    ]
                                );
                            },
                            'delete' => function($url, $model) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-trash"></span>',
                                    ['/vacancyNotification/notification/change-status',
                                        'id' => $model->id,
                                        'status' => VacancyNotification::CANCELED
                                    ],
                                    [
                                        'title' => 'Отклонить'
                                    ]
                                );
                            }
                        ],
                        'template' => '{archive} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>