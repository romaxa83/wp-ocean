<?php
use dosamigos\fileupload\FileUploadUI;
use backend\modules\filemanager\FileManager;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel pendalf89\filemanager\models\Mediafile */

?>

<header id="header"><span class="glyphicon glyphicon-upload"></span> <?= FileManager::t('main', 'Upload manager') ?></header>

<div id="uploadmanager">
    <p><?= Html::a('← ' . FileManager::t('main', 'Back to file manager'), ['file/filemanager']) ?></p>
    <?= FileUploadUI::widget([
        'model' => $model,
        'attribute' => 'file',
        'clientOptions' => [
            'autoUpload'=> Yii::$app->getModule('filemanager')->autoUpload,
        ],
        'clientEvents' => [
            'fileuploadsubmit' => "function (e, data) { data.formData = [{name: 'tagIds', value: $('#filemanager-tagIds').val()}]; }",
        ],
        'url' => ['upload'],
        'gallery' => false,
        'formView' => '/file/_upload_form',
    ]) ?>
</div>
