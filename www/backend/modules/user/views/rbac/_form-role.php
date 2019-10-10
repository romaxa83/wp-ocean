<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\forms\rbac\RoleForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $allRoles */

?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="role-form">
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Основные поля</h3>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->textInput() ?>

                    <?= $form->field($model, 'description')->textInput() ?>

                </div>
            </div>
        </div>

        <div class="col-lg-offset2 col-lg-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Существующие роли</h3>
                </div>
                <div class="box-body">
                    <?= $this->render('exist-roles',[
                        'roles' => $allRoles
                    ])?>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary mr-15']) ?>
        <?= Html::a('Отменить', ['/user/rbac/index'], ['class' => 'btn btn-danger mr-15']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
