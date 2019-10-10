<?php

use app\modules\user\UserAsset;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\user\helpers\Status;
use backend\modules\user\helpers\SexHelper;
use backend\modules\user\helpers\DateFormat;
use backend\modules\blog\helpers\ImageHelper;
use backend\modules\blog\helpers\StatusHelper;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $modificationsProvider yii\data\ActiveDataProvider */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Пользователь: ' . $user->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
UserAsset::register($this);
?>
<div class="user-view">
    <p>
        <?php if($access->accessInView(Url::toRoute(['update']))):?>
            <?= Html::a('Редактировать', Url::toRoute(['update', 'id' => $user->id]), ['class' => 'btn btn-primary']) ?>
        <?php endif;?>
        <?= Html::a('Вернуться', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?php if($access->accessInView(Url::toRoute(['delete']))):?>
        <?php endif;?>
        <?= Html::a('Удалить', Url::toRoute(['delete', 'id' => $user->id]), [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены ,что хотите удалить этого пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $user,
                        'attributes' => [
                            [
                                'label' => 'Avatar',
                                'format' => 'raw',
                                'value' => $user->media_id !==null
                                    ? ImageHelper::getAvatar($user->media_id)
                                    : ImageHelper::notAvatar(),
                            ],
                            'id',
                            [
                                'label' => 'Имя',
                                'value' => $user->passport->first_name,
                            ],
                            [
                                'label' => 'Фамилия',
                                'value' => $user->passport->last_name,
                            ],
                            [
                                'label' => 'Email',
                                'value' => $user->email,
                            ],
                            [
                                'label' => 'Телефон',
                                'value' => $user->phone,
                            ],
                            [
                                'label' => 'Дата регистрации',
                                'value' => DateFormat::viewTimestamp($user->created_at),
                            ],
                            [
                                'label' => 'Роль',
                                'format' => 'raw',
                                'value' => function(User $model) use ($access){
                                    $html_add = $access->accessInView('user/rbac/attachRoleForUser')
                                        ? '<span class="btn-roles add-roles" 
                                                 title="Привязать дополнительную роль пользователю"
                                                 data-roles="'.$model->getRoles().'">
                                                 <i class="fa fa-plus-square"></i>
                                           </span>'
                                        : '';
                                    $html_del =  $access->accessInView('user/rbac/detachedRoleForUser')
                                        ? '<span class="btn-roles remove-roles" 
                                                 title="Удалить дополнительную роль"
                                                 data-roles="'.$model->getRoles().'">
                                                 <i class="fa fa-minus-square"></i>
                                           </span>'
                                        : '';

                                    return '<div class="roles-panel" data-id="'. $model->id .'" >
                                                <span class="roles">'. $model->getRolesDescription() .'</span>
                                                '. $html_add . $html_del .'
                                            </div>';
                                }
                            ],
                            [
                                'label' => 'Подписка на новости',
                                'format' => 'raw',
                                'value' => StatusHelper::label($user->dispatch),
                            ],
                            [
                                'label' => 'Верификация паспорта',
                                'format' => 'raw',
                                'value' => StatusHelper::label(isVerifyPassport()),
                            ],
                            [
                                'label' => 'Верификация загранпаспорта',
                                'format' => 'raw',
                                'value' => StatusHelper::label(isVerifyIntPassport()),
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Smart-рассылка пользователя</h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <?= \backend\modules\user\widgets\smartMailing\SmartMailingWidget::widget([
                        'template' => 'all-smart-subscription',
                        'user_id' => $user->id,
                        'for_admin' => true
                    ])?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    Паспортные данные(укр.) <?= isVerifyPassport()?Status::verify($user->passport->verify):''?>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $user->passport,
                        'attributes' => [
                            [
                                'label' => 'Отчество',
                                'value' => $user->passport->patronymic,
                            ],
                            [
                                'label' => 'Дата рождения',
                                'value' => DateFormat::forView($user->passport->birthday),
                            ],
                            [
                                'label' => 'Серия',
                                'value' => $user->passport->series,
                            ],
                            [
                                'label' => 'Номер',
                                'value' => $user->passport->number,
                            ],
                            [
                                'label' => 'Кем выдан',
                                'value' => $user->passport->issued,
                            ],
                            [
                                'label' => 'Когда выдан',
                                'value' => DateFormat::forView($user->passport->issued_date),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <?php if(isVerifyPassport()):?>
            <div class="col-md-6">
                <div class="box">
                    <?php if($user->passport->media_id !== null):?>
                        <div class="box-header with-border">
                            <?php if($access->accessInView(Url::toRoute(['verify']))):?>
                                <?= Html::a((bool)$user->passport->verify?'Отменить верификацию':'Верифицировать',
                                    Url::toRoute(['verify']),
                                    [
                                        'class' => 'btn btn-primary',
                                        'data-method' => 'POST',
                                        'data-params' => [
                                            'verify' => $user->passport->verify,
                                            'passport_id' => $user->passport->id
                                        ]
                                    ])?>
                            <?php endif;?>
                            <?php if($access->accessInView(Url::toRoute(['reject-scan']))):?>
                                <?= Html::a('Откланить скан',
                                    Url::toRoute(['reject-scan']),
                                    [
                                        'class' => 'btn btn-danger',
                                        'title' => 'Скан отвеграеться из-за плохого качества с соответствующим уведомлением пользователя',
                                        'data-method' => 'POST',
                                        'data-params' => [
                                            'passport_id' => $user->passport->id,
                                            'passport_type' => 'ukr'
                                        ]
                                    ])?>
                            <?php endif;?>
                        </div>
                        <div class="box-body"><?= ImageHelper::renderImg($user->passport->media->thumbs,'large')?></div>
                    <?php else:?>
                        <div class="box-header with-border">Скан не загружен</div>
                        <div class="box-body"><?= ImageHelper::notImg()?></div>
                    <?php endif;?>
                </div>
            </div>
        <?php endif;?>
    </div>
    <?php if($user->intPassports):?>
        <div class="row">
            <div class="col-md-<?= isVerifyIntPassport()?'12':'6'?>">
                <div class="box">
                    <div class="box-header with-border"><h4 class="text-center">Привязаные загранпаспорта (<?= count($user->intPassports)?>)</h4></div>
                </div>
            </div>
        </div>
        <?php foreach ($user->intPassports as $key => $intPassport):?>
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            Данные загранпаспорта № <?= $key+1 ?> <?= isVerifyIntPassport()?Status::verify($intPassport->verify):''?>
                            <?php if(Url::toRoute(['remove-int'])):?>
                                <?= Html::a('',
                                    Url::toRoute(['remove-int']),
                                    [
                                        'class' => 'grid-option fa fa-trash',
                                        'style' => 'float:right',
                                        'title' => 'Удалить данный,привязаный, загранпаспорт',
                                        'data-method' => 'POST',
                                        'data-params' => [
                                            'passport_id' => $intPassport->id
                                        ]
                                    ])?>
                            <?php endif;?>
                        </div>
                        <div class="box-body">
                            <?= DetailView::widget([
                                'model' => $intPassport,
                                'attributes' => [
                                    [
                                        'label' => 'Имя',
                                        'value' => $intPassport->first_name,
                                    ],
                                    [
                                        'label' => 'Фамилия',
                                        'value' => $intPassport->last_name,
                                    ],
                                    [
                                        'label' => 'Пол',
                                        'value' => SexHelper::list($intPassport->sex),
                                    ],
                                    [
                                        'label' => 'Дата рождения',
                                        'value' => DateFormat::forView($intPassport->birthday),
                                    ],
                                    [
                                        'label' => 'Серия',
                                        'value' => $intPassport->series,
                                    ],
                                    [
                                        'label' => 'Номер',
                                        'value' => $intPassport->number,
                                    ],
                                    [
                                        'label' => 'Кем выдан',
                                        'value' => $intPassport->issued,
                                    ],
                                    [
                                        'label' => 'Когда выдан',
                                        'value' => DateFormat::forView($intPassport->issued_date)
                                    ],
                                    [
                                        'label' => 'Срок действия',
                                        'value' => DateFormat::forView($intPassport->expired_date),
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
                <?php if(isVerifyIntPassport()):?>
                    <div class="col-md-6">
                        <div class="box">
                            <?php if($intPassport->media_id !== null):?>
                                <div class="box-header with-border">
                                    <?php if($access->accessInView(Url::toRoute(['verify-int']))):?>
                                        <?= Html::a((bool)$intPassport->verify?'Отменить верификацию':'Верифицировать',
                                            Url::toRoute(['verify-int']),
                                            [
                                                'class' => 'btn btn-primary',
                                                'data-method' => 'POST',
                                                'data-params' => [
                                                    'verify' => $intPassport->verify,
                                                    'passport_id' => $intPassport->id
                                                ]
                                            ])?>
                                    <?php endif;?>
                                    <?php if($access->accessInView(Url::toRoute(['update-int']))):?>
                                        <?= Html::a('Редактировать',
                                            Url::toRoute(['update-int','id' => $intPassport->id,'user_id' => $user->id]),
                                            [
                                                'class' => 'btn btn-primary',
                                            ])?>
                                    <?php endif;?>
                                    <?php if($access->accessInView(Url::toRoute(['reject-scan']))):?>
                                        <?= Html::a('Откланить скан',
                                            Url::toRoute(['reject-scan']),
                                            [
                                                'class' => 'btn btn-danger',
                                                'data-method' => 'POST',
                                                'data-params' => [
                                                    'passport_id' => $intPassport->id,
                                                    'passport_type' => 'int'
                                                ]
                                            ])?>
                                    <?php endif;?>
                                </div>
                                <div class="box-body"><?= ImageHelper::renderImg($intPassport->media->thumbs,'large')?></div>
                            <?php else:?>
                                <div class="box-header with-border">Скан не загружен</div>
                                <div class="box-body"><?= ImageHelper::notImg()?></div>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        <?php endforeach;?>
    <?php endif;?>

</div>