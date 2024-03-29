<?php

use backend\modules\filemanager\FileManager;
use kartik\alert\Alert;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = FileManager::t('main', 'Settings');
$this->params['breadcrumbs'][] = ['label' => FileManager::t('main', 'File manager'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="filemanager-default-settings">
    <h1><?= $this->title ?></h1>

    <div class="panel panel-default">
        <div class="panel-heading"><?= FileManager::t('main', 'Thumbnails settings') ?></div>
        <div class="panel-body">
            <?php if (Yii::$app->session->getFlash('successResize')) : ?>
                <?= Alert::widget([
                    'type' => Alert::TYPE_SUCCESS,
                    'title' => FileManager::t('main', 'Thumbnails sizes has been resized successfully!'),
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'body' => FileManager::t('main', 'Do not forget every time you change thumbnails presets to make them resize.'),
                    'showSeparator' => true,
                ]); ?>
            <?php endif; ?>
            <p><?= FileManager::t('main', 'Now using next thumbnails presets') ?>:</p>
            <ul>
                <?php foreach ($this->context->module->thumbs as $preset) : ?>
                    <li><strong><?= $preset['name'] ?>:</strong> <?= $preset['size'][0] .' x ' . $preset['size'][1] ?></li>
                <?php endforeach; ?>
            </ul>
            <p><?= FileManager::t('main', 'If you change the thumbnails sizes, it is strongly recommended to make resize all thumbnails.') ?></p>
            <?= Html::a(FileManager::t('main', 'Do resize thumbnails'), ['file/resize'], ['class' => 'btn btn-danger']) ?>
        </div>
    </div>
</div>