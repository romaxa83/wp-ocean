<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\user\UserAsset;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $model backend\modules\user\forms\UserForm */
/* @var $form yii\widgets\ActiveForm */
UserAsset::register($this);
?>
<style>
    div.required label:after {
        content: " *";
        color: red;
    }
</style>
<div class="user-form">
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Основные поля</h3>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'role')->dropDownList(
                        $model->getRoles(),[
                            'prompt' => 'Выберите роль'
                        ]
                    ) ?>

                    <?= $form->field($model->passport, 'first_name')->textInput()->label('Имя') ?>

                    <?= $form->field($model->passport, 'last_name')->textInput()->label('Фамилия') ?>

                    <?= $form->field($model, 'email')->textInput() ?>

                    <?php $passwordLabel = Yii::$app->controller->action->id == 'create'?'Пароль':'Новый пароль'?>
                    <?= $form->field($model, 'password', [
                        'template' => '{label}<div class="input-group">
                            <div class="input-group-addon password_eye" style="cursor: pointer">
                            <i class="fa fa-eye"></i>
                            </div>{input}
                            </div>{hint}{error}',
                    ])->passwordInput()->label($passwordLabel) ?>

                    <?= $form->field($model, 'phone', [
                        'template' => '{label}<div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                        </div>{input}
                        </div>{hint}{error}',
                    ])->widget( yii\widgets\MaskedInput::class, [
                        'name' => 'phone',
                        'mask' => '+38(999)-999-9999'
                    ])?>

                </div>
            </div>
        </div>
        <!--  Passport  -->
        <div class="col-lg-6 passport-form" style="display:none">
            <?= $this->render('_form_passport',[
                'form' => $form,
                'model'=> $model
            ])?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary mr-15']) ?>
        <?= Html::a('Отменить', ['/user/user/index'], ['class' => 'btn btn-danger mr-15']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
