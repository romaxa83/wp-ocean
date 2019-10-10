<?php

use yii\helpers\Html;
use app\modules\user\UserAsset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $allPermissions */
/* @var $checkPermissions */
/* @var $allRoles */
/* @var $checkRole */
/* @var $groupPermissions */
/* @var $access backend\modules\user\useCase\Access */

$this->title = 'Роли и разрешения';
$this->params['breadcrumbs'][] = $this->title;
UserAsset::register($this);
?>
<div class="role-index">
    <div class="row mb-15">
        <div class="col-xs-6">
            <?php if($access->accessInView(Url::toRoute(['create-role']))):?>
                <?= Html::a('Создать роль', Url::toRoute(['create-role']), ['class' => 'btn btn-primary']) ?>
            <?php endif;?>
            <?= Html::button('Справка', ['class' => 'info-rbac-show btn btn-primary']) ?>
        </div>
        <div class="col-xs-1">
            <?php if($allPermissions):?>
                <?= Html::checkbox('allCheck',false,[
                    'class' => 'permission-all-check',
                    'label' => 'Выбрать'
                ])?>
            <?php endif;?>
        </div>
        <div class="col-xs-2">
            <?php if($groupPermissions):?>
                <?= Html::dropDownList('Group',false,$groupPermissions,[
                    'class' => 'form-control group-permission',
                    'label' => 'Выбрать все'
                ])?>
            <?php endif;?>
        </div>
        <div class="col-xs-2">
            <?php if($access->accessInView(Url::toRoute(['upload-permissions']))):?>
                <?= Html::a('Загрузить разрешения',
                    Url::toRoute(['upload-permissions']),
                    [
                        'class' => 'btn btn-primary',
                        'data-method' => 'POST',
                        'data-params' => [
                            'status' => 'upload'
                        ]
                    ])?>
            <?php endif;?>
        </div>
    </div>
    <div class="box info-rbac" style="display: none">
        <div class="box-body">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <h4 class="align-center">Справка</h4>
                    <p>
                        Выберить роль,если их нет то создайте ( к примеру: модератор,менеджер,...),
                        после выберите для этой роли разрешения
                        на определеные действия.После создайте пользователя и присвойте ему созданую
                        роль.Данные пользователь сможет видеть только те разделы и совершать только те
                        действия ,которые вы выберете для роли.
                    </p>
                    <p>Стоит помнить:</p>
                    <ul>
                        <li>Нельзя создать роль Пользователь(user) и Администратор(admin),они уже созданны в системе</li>
                        <li>Им также нельзя назначить разрешения(user - не имеет доступа к админ-панели,admin - имеет абсолютную свободу действи)</li>
                        <li>Зарегистрированные пользователи автоматически получают роль Пользователь(user)</li>
                        <li>Во избежания не приятностей,в системе может быть только один Администратор(admin)</li>
                        <li>Удалить,созданую вами роль,можно только при условии что она не назначена пользователю</li>
                        <li>Пользователю можно добавить несколько ролей (на стр. просмотра пользователя,значок "+"),тогда он получит все разрешения полученых ролей</li>
                        <li>Если у пользователя больше одной роли,их можно удалить(на стр. просмотра пользователя,значок "-"),но у пользователя всегда должна быть хотя бы одна роль</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 allRoles">
                    <?= $this->render('_index_role',[
                        'allRoles' => $allRoles,
                        'checkRole' => $checkRole,
                        'access' => $access
                    ])?>
                </div>
                <div class="col-md-6 allPermissions">
                    <?= $this->render('_index_perm',[
                        'allPermissions' => $allPermissions,
                        'checkPermissions' => $checkPermissions,
                        'access' => $access
                    ])?>
                </div>
            </div>
        </div>
    </div>
</div>