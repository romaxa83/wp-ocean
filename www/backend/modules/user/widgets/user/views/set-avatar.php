<?php

use backend\modules\blog\helpers\ImageHelper;
use backend\modules\filemanager\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model backend\modules\user\forms\UserEditForm */
/* @var $user common\models\User */

?>

<fieldset>
    <legend>Изменить фото</legend>
    <div class="row">
        <div class="col-md-5">
            <?php if($user->media_id):?>
                <?= ImageHelper::getAvatar($user->media_id,true)?>
            <?php else:?>
                <?= ImageHelper::notAvatar(true)?>
            <?php endif;?>
        </div>
        <?php $form = ActiveForm::begin([
            'id' => 'form-set-avatar',
            'action' => ['/cabinet/settings/set-avatar','id' => $user->id],
        ]); ?>
        <div class="col-md-5">
            <?= $form->field($model, 'media_id')->widget(FileInput::className(), [
                'buttonTag' => 'button',
                'buttonName' => 'Выбрать',
                'buttonOptions' => ['class' => 'btn btn-default'],
                'options' => ['class' => 'form-control', 'readonly' => 'readonly'],
                'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                'thumb' => 'original',
                'imageContainer' => '.img',
                'frameSrc' => '/admin/filemanager/file/filemanager',
                'pasteData' => FileInput::DATA_ID
            ])->label('Загрузите свое фото'); ?>
        </div>
        <div class="col-md-2">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</fieldset>