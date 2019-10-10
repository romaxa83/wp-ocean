<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use kartik\date\DatePicker;
use app\modules\user\UserAsset;
use backend\modules\user\helpers\DateFormat;
use backend\modules\blog\helpers\StatusHelper;
use backend\modules\blog\components\CustomActionColumn;
use backend\modules\blog\widgets\settings\SettingsWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\forms\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */
/* @var $user_settings */
/* @var $page */
/* @var $roles */

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;

UserAsset::register($this);

?>
<div class="user-index">

<!--    <div class="row mb-15">-->
<!--        <div class="col-xs-12">-->
<!--            <?php //$verify_status = isVerifyPassport()? 'выключить':'включить'?>-->
<!--            <?php //if($access->accessInView(Url::toRoute(['create']))):?>-->
<!--            <?//= Html::a('Создать пользователя', Url::toRoute(['create']), ['class' => 'btn btn-primary']) ?>-->
<!--            <?php //endif;?>-->
<!--            <?php //if(Url::toRoute(['verify-toggle'])):?>-->
<!--                <?//= Html::a(isVerifyPassport()?'Выкл. вериф. паспорта':'Вкл. вериф. паспорта',
//                    Url::toRoute(['verify-toggle']),
//                    [
//                        'class' => 'btn btn-primary',
//                        'data-confirm' => 'Вы уверены, что хотите '.$verify_status.' верификацию для паспортов(укр)?',
//                        'data-method' => 'POST',
//                        'data-params' => [
//                            'status' => isVerifyPassport()?'0':'1',
//                            'name' => 'verify_passport'
//                        ]
//                    ])?>-->
<!--                <?//= Html::a(isVerifyIntPassport()?'Выкл. вериф. загранпаспорта':'Вкл. вериф. загарнпаспорта',
//                    Url::toRoute(['verify-toggle']),
//                    [
//                        'class' => 'btn btn-primary',
//                        'data-confirm' => 'Вы уверены, что хотите '.$verify_status.' верификацию для загранпаспортов?',
//                        'data-method' => 'POST',
//                        'data-params' => [
//                            'status' => isVerifyIntPassport()?'0':'1',
//                            'name' => 'verify_int_passport'
//                        ]
//                    ])?>-->
<!--            <?php //endif;?>-->
<!--        </div>-->
<!--    </div>-->

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Список пользователей</h3>
        </div>
        <div class="box-body table-flexible">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-hover'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id',
                        'label' => 'ID',
                        'format' => 'raw',
                        'value' => function(User $model){
                            return $model->id;
                        },
                        'contentOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('id',$user_settings['hide-col']??null,['width' => '50']),
                    ],
                    [
                        'attribute' => 'first_name',
                        'label' => 'Имя',
                        'format' => 'raw',
                        'value' => function(User $model) use($access){
                            if($access->accessInView(Url::toRoute(['view']))){
                                return Html::a(Html::encode($model->passport->first_name), ['view', 'id' => $model->id]);
                            }
                            return Html::encode($model->passport->first_name);
                        },
                        'contentOptions' => SettingsWidget::setConfig('first_name',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('first_name',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('first_name',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'last_name',
                        'label' => 'Фамилия',
                        'format' => 'raw',
                        'value' => function(User $model) use($access){
                            if($access->accessInView(Url::toRoute(['view']))){
                                return Html::a(Html::encode($model->passport->last_name), ['view', 'id' => $model->id]);
                            }
                            return Html::encode($model->passport->last_name);
                        },
                        'contentOptions' => SettingsWidget::setConfig('last_name',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('last_name',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('last_name',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'raw',
                        'value' => function(User $model){
                            return $model->email;
                        },
                        'contentOptions' => SettingsWidget::setConfig('email',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('email',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('email',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'phone',
                        'format' => 'raw',
                        'value' => function(User $model){
                            return $model->phone;
                        },
                        'contentOptions' => SettingsWidget::setConfig('phone',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('phone',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('phone',$user_settings['hide-col']??null),
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function(User $model){
                            return DateFormat::viewTimestamp($model->created_at);
                        },
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'language' => 'ru',
                            'type' =>DatePicker::TYPE_COMPONENT_APPEND,
                            'attribute' => 'created_at',
                            'options' => ['placeholder' => 'Дата регистрации'],
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'orientation' => 'bottom',
                                'autoUpdateInput' => false,
                                'format' => 'dd-MM-yyyy',
//                                'format' => 'dd/MM/yyyy',
                                'autoclose'=>true,
                                'weekStart'=>1, //неделя начинается с понедельника
                            ]
                        ]),
                        'contentOptions' => SettingsWidget::setConfig('created_at',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('created_at',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('created_at',$user_settings['hide-col']??null,['class' => 'minw-200px']),
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function(User $model){
                            return StatusHelper::labelUser($model->status);
                        },
                        'contentOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null),
                        'headerOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null),
                        'filterOptions' => SettingsWidget::setConfig('status',$user_settings['hide-col']??null),
                    ],
//                    [
//                        'attribute' => 'role',
//                        'format' => 'raw',
//                        'value' => function(User $model){
//                            return $model->getRolesDescription();
//                        },
//                        'filter' => $roles,
//                        'contentOptions' => SettingsWidget::setConfig('role',$user_settings['hide-col']??null),
//                        'headerOptions' => SettingsWidget::setConfig('role',$user_settings['hide-col']??null),
//                        'filterOptions' => SettingsWidget::setConfig('role',$user_settings['hide-col']??null),
//                    ],
                    [
                        'class' => CustomActionColumn::className(),
                        'header' => SettingsWidget::widget([
                            'model' => 'user',
                            'count_page' => $page,
                            'hide_col' => $user_settings['hide-col']??null,
                            'attribute' => [
                                'id' => 'ID',
                                'first_name' => 'Имя',
                                'last_name' => 'Фамилия',
                                'email' => 'Email',
                                'phone' => 'Телефон',
                                'created_at' => 'Дата регистрация',
//                                'role' => 'Роль',
                                'status' => 'Статус'
                            ]
                        ]),
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function($url, $model, $index) use($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Просмотр пользователя',
                                        'aria-label' => 'Просмотр пользователя',
                                        'class' => 'grid-option fa fa-eye',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'update' => function($url, $model, $index) use($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Редактировать пользователя',
                                        'aria-label' => 'Редактировать пользователя',
                                        'class' => 'grid-option fa fa-pencil',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            },
                            'delete' => function($url, $model, $index) use ($access) {
                                if($access->accessInView($url)){
                                    return Html::tag(
                                        'a',
                                        '',[
                                        'href' => $url,
                                        'title' => 'Удалить пользователя',
                                        'aria-label' => 'Удалить ползователя',
                                        'class' => 'grid-option fa fa-trash',
                                        'data-confirm' => 'Вы уверены, что хотите удалить этот пользователя?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0'
                                    ]);
                                }
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
